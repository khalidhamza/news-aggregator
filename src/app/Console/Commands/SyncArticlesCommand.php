<?php

namespace App\Console\Commands;

use App\Jobs\SyncArticlesJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dispatch a job to sync articles from news sources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("========================= SyncArticlesCommand:START =========================");

        SyncArticlesJob::dispatch();

        $this->info('Dispatched sync jobs for all sources');

        Log::info("========================= SyncArticlesCommand:END =========================");
    }
}
