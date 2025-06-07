<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCategoriesWithParent
{
    use AsAction;

    public function handle(): Collection
    {
        return Category::with('parent')
            ->get();
    }
}
