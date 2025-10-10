<?php

namespace App\Http\Controllers;

use App\Enums\NewsSource;
use App\Jobs\SyncArticlesJob;
use App\Services\NewsService\NewsServiceFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TestController extends AppController
{
    public function test(Request $request)
    {
        try {
            /*$service = NewsServiceFactory::make(NewsSource::NEWSAPI);
            $articles = $service->syncArticles([
                'keyword' => 'technology',
                'from_date' => now()->subDays(7),
                'per_page' => 100,
            ]);
            dd($articles);*/


            /*$services = NewsServiceFactory::makeAll();
            $services->each(function($service){
                dd($service->getArticles());
            });*/

            // SyncArticlesJob::dispatch();

            // Artisan::call('articles:sync');

        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
