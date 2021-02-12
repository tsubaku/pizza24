<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\IndexRepository;

class IndexController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository
     */

    private $categoryRepository;
    /**
     * @var IndexRepository
     */
    private $indexRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->indexRepository = app(IndexRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }


    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $selectedCategory = $request->category;
        $paginator = $this->indexRepository->getWithPaginate(10, $selectedCategory);

        $categoryList = $this->categoryRepository->getForComboBox();

        return view('index', compact('paginator', 'categoryList'));
    }
}
