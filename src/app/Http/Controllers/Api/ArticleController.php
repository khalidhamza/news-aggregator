<?php

namespace App\Http\Controllers\Api;

use App\Enums\NewsSource;
use App\Http\Controllers\AppController;
use App\Http\Requests\GetArticlesRequest;
use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepository;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ArticleController extends AppController
{
    public function __construct(private readonly ArticleRepository $repository)
    {
    }

    public function getArticles(GetArticlesRequest $request)
    {
        try {
            $filters = $request->validated();

            return ArticleResource::collection($this->repository->getArticles($filters));

        }catch (\Throwable $th){
            return ApiResponse::failed($th->getMessage(), $th->getCode());
        }
    }

    public function getFilters(Request $request)
    {
        try {
            $result = [
                'categories' => $this->repository->getCategories(),
                'authors' => $this->repository->getAuthors(),
                'sources' => NewsSource::casesNames(),
            ];
            return ApiResponse::success($result);
        }catch (\Throwable $th){
            return ApiResponse::failed($th->getMessage(), $th->getCode());
        }
    }


}
