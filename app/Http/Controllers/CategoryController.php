<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * index
     *
     * @return void
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryRepository->all();

        return CategoryResource::collection($categories)->response();
    }
}
