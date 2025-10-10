<?php

namespace App\Jobs;

use App\Enums\NewsSource;
use App\Services\NewsService\NewsServiceFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Exception;
use RuntimeException;

class SyncArticlesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 90;

    public int $backoff = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private ?NewsSource $source = null,
        private array $filters = []
    ) {
        if (empty($this->filters['from_date'])) {
            $this->filters['from_date'] = now()->subMinutes(70)->format('Y-m-d\TH:i:s');
        }

        if (empty($this->filters['per_page'])) {
            $this->filters['per_page'] = 100;
        }
    }

    public function handle(): void
    {
        Log::info("========================= START =========================");
        Log::info('Starting article sync job', [
            'source' => $this->source?->name ?? 'all',
            'filters' => $this->filters,
            'attempt' => $this->attempts(),
        ]);

        try {
            // If no source provided, dispatch separate jobs for each source
            if ($this->source === null) {
                Log::info('Dispatching individual sync jobs for all sources');

                foreach (NewsSource::cases() as $source) {
                    SyncArticlesJob::dispatch($source, $this->filters);
                }

                Log::info('Successfully dispatched sync jobs', [
                    'sources_count' => count(NewsSource::cases()),
                ]);

                return;
            }

            // create a service instance and sync articles
            $service = NewsServiceFactory::make($this->source);
            $result = $service->syncArticles($this->filters);

            Log::info('Article sync result', [
                'source' => $this->source->name,
                'result' => $result,
            ]);

            // throw exception to retry
            if (! $result['success']) {
                Log::info("========================= END (Failed) =========================");
                throw new RuntimeException($result['error'] ?? 'Sync failed');
            }

        } catch (Exception $e) {
            Log::critical('Article sync job exception', [
                'source' => $this->source?->value ?? 'all',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'attempt' => $this->attempts(),
            ]);

            // re-throw exception
            Log::info("========================= END (Exception) =========================");
            throw $e;
        }

        Log::info("========================= END =========================");
    }

    public function failed(Exception $exception): void
    {
        Log::critical('Article sync job failed after all retries', [
            'source' => $this->source,
            'filters' => $this->filters,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts(),
        ]);
    }
}
