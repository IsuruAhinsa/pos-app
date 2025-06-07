<?php

namespace App\Repositories;

use App\Actions\Category\GetCategoriesWithParent;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getCategoriesWithParent(): AnonymousResourceCollection
    {
        return CategoryResource::collection(GetCategoriesWithParent::run());
    }

    public function prepareCategoryData(array $data): array
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $data;
    }
}
