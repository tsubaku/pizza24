<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductCreateRequest;

use Illuminate\Support\Facades\Storage;

//use App\Traits\UniqueModelSlug;

class ProductController extends Controller
{
    //use UniqueModelSlug;

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
        //dd($request->input());
        // $data = $request->input();
        $data = $this->productRepository->processRequest($request);

        //$item = (new Product())->create($data);
        $item = new Product($data);

        $item->slug = $this->generateSlug(
            Product::class, // указываем модель строкой, т.к. добавляем новую строку
            $item->title
        ); // 1-blog


        $saveResult = $item->save();

        $goTo = $this->productRepository->redirectAfterSaveProduct($saveResult, $item);

        return $goTo;
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
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
     //   $item = $this->productRepository->getEdit($id);
        $item = $this->productRepository->getEditSlug($slug);
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
        //$item = $this->productRepository->getEditSlug($slug);
        $item = $this->productRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Product $id not found"])
                ->withInput();
        }

        $data = $this->productRepository->processRequestUpdate($request, $item);




        $saveResult = $item->update($data);             //writing in DB
        //$saveResult = $item->fill($data)->save();     //analog

     //   dd($item->slug, $id, $saveResult, $data, $item, $request);
        $goTo = $this->productRepository->redirectAfterSaveProduct($saveResult, $item);

        return $goTo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        #Soft delete
        //$result = Product::destroy($id); //$result will contain the number of deleted records

        #Full delete
        $item = $this->productRepository->getEditSlug($slug);
        $title = $item->title;

        #Delete image from disk
        if ($item->image_url) {
            Storage::delete('public/' . $item->image_url);
        }
        //$result = Product::find($id)->forceDelete();
        $result = $item->forceDelete();
        //$result = $this->productRepository->deleteProduct($item);

        #Redirect
        if ($result) {
            return redirect()
                ->route('admin.products.index')
                ->with(['success' => "Product `$title` has been removed"]);
        } else {
            return back()->withErrors(['msg' => 'Delete error']);
        }
    }
}
