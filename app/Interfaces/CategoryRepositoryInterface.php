<?php

namespace App\Interfaces;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getCategoriesWithParent(): AnonymousResourceCollection;

    public function prepareCategoryData(array $data): array;
}
