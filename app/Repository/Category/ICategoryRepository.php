<?php

namespace App\Repository\Category;

use App\Models\Category;

interface ICategoryRepository
{
    public function listCategories(): object;
    public function listCategoriesByPluck(): object;
    public function getCategoryById(int $id): ?Category;
    public function createCategory(string $name): void;
    public function updateCategory(int $id, string $name): void;
    public function deleteCategory(int $id): void;
}
