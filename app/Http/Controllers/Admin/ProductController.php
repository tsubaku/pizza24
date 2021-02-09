<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductCreateRequest;


class ProductController extends Controller
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
     * PostController constructor.
     */
    public function __construct()
    {
        $this->productRepository = app(ProductRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }


    public function index()
    {
        $paginator = $this->productRepository->getAllWithPaginate(10);
//dd($paginator);
        return view('admin.products.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Product();
        $categoryList = $this->categoryRepository->getForComboBox();

        return view('admin.products.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        $data = $request->input();

        $item = (new Product())->create($data);

        if ($item) {
            return redirect()->route('admin.products.edit', [$item->id])
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->productRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $categoryList = $this->categoryRepository->getForComboBox(); //what category does the post belong to?

        return view('admin.products.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
       // $is_published = (bool)$request->get('is_published', false);

     //   dd($request);
        $item = $this->productRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Product id=$id not found"])
                ->withInput();
        }
        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('admin.products.edit', $item->id)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()
                ->withErrors('msg', 'Save error')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Soft delete
        $result = Product::destroy($id); //$result will contain the number of deleted records

        //Full delete
        //$result = Product::find($id)->forceDelete();

        if ($result) {
            return redirect()
                ->route('admin.products.index')
                ->with(['success' => "Product $id was deleted"]);
        } else {
            return back()->withErrors(['msg' => 'Delete error']);
        }
    }
}
