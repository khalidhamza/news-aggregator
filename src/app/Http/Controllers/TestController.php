<?php

namespace App\Http\Controllers;

use App\Enums\NewsSource;
use App\Services\NewsService\NewsServiceFactory;
use Illuminate\Http\Request;

class TestController extends AppController
{
    public function test(Request $request)
    {
        try {
            $service = NewsServiceFactory::make(NewsSource::NEWSAPI);

            $articles = $service->syncArticles([
                'keyword' => 'technology',
                'from_date' => now()->subDays(7),
            ]);

            dd($articles);

            /*$services = NewsServiceFactory::makeAll();
            $services->each(function($service){
                dd($service->getArticles());
            });*/
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
