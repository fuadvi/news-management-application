<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repository\Category\ICategoryRepository;
use App\Traits\ResponseAPI;

class CategoryController extends Controller
{
    use ResponseAPI;
    public function __construct(
        private ICategoryRepository $categoryRepo
    ) {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            'Categories list',
            $this->categoryRepo->listCategories()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepo->createCategory($request->name);
        return $this->success('Category created', null);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->success(
            'Category detail',
            $this->categoryRepo->getCategoryById($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $this->categoryRepo->updateCategory($id, $request->name);
        return $this->success(
            'Category updated',
            null
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryRepo->deleteCategory($id);
        return $this->success(
            'Category deleted',
            null
        );
    }
}
