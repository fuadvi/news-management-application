<?php

namespace App\Repository\Category;

use App\Models\Category;

class CategoryRepository implements ICategoryRepository
{
    public function __construct(
        private Category $category
    ) {
    }


    public function listCategories(): object
    {
        return $this->category->paginate(10);
    }

    public function listCategoriesByPluck(): object
    {
        return $this->category
            ->pluck('name', 'id')
            ->prepend('Select category', '');
    }

    public function getCategoryById(int $id): ?Category
    {
        return $this->category->findOrFail($id);
    }

    public function createCategory(string $name): void
    {
        $this->category->create([
            'name' => $name
        ]);
    }

    public function updateCategory(int $id, string $name): void
    {
        $this->category->findOrFail($id)
            ->update(
                [
                    'name' => $name
                ]
            );
    }

    public function deleteCategory(int $id): void
    {
        $this->category->find($id)?->delete();
    }
}
