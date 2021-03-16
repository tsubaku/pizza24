<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
//use Illuminate\Http\Request;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\CategoryCreateRequest;

use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
        $this->productRepository = app(ProductRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->categoryRepository->getAllWithPaginate(10);

        return view('admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$item = new Category();
        $item = Category::make(); //option of creating an object through the laravel builder

        $categoryList = $this->categoryRepository->getForComboBox();

        return view('admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        //$data = $request->input();
        $data = $this->categoryRepository->processRequest($request);

        #Create and save to db object
        //1 Way
        $item = new Category($data);
        $saveResult = $item->save();

        //2 Way  through the laravel builder
        //$item = (new Category())->create($data);

        //3 Way
        //$item = Category::create($data);

        $goTo = $this->categoryRepository->redirectAfterSaveCategory($saveResult, $item);

        return $goTo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
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
        $item = $this->categoryRepository->getEditSlug($slug);
        if (empty($item)) {
            abort(404);
        }
        $categoryList = $this->categoryRepository->getForComboBox();

        return view('admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        //$item = $this->categoryRepository->getEditSlug($slug);
        $item = $this->categoryRepository->getEdit($id);
        $title = $item->title;

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Category `$title` not found"])
                ->withInput();
        }

        $data = $this->categoryRepository->processRequest($request);
        $saveResult = $item->update($data);             //writing in DB
        //$saveResult = $item->fill($data)->save();     //analog

        $goTo = $this->categoryRepository->redirectAfterSaveCategory($saveResult, $item);

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
        $item = $this->categoryRepository->getEditSlug($slug);
        $title = $item->title;

        try {
            //Soft removal, remains in the database
            //Category::destroy($id); //$result - count of deleted records

            //$result = Category::find($id)->forceDelete();
            $item->forceDelete(); //Complete removal from the database

            #Delete image from disk
            if ($item->image_url) {
                Storage::delete('public/' . $item->image_url);
            }
        } catch (\Exception  $e) {
            #Get names of sub items
            $subCategoryNames = $this->categoryRepository->getSubCategoriesNames($item->id);
            $subProductNames = $this->productRepository->getSubProductsNames($item->id);
            $subItemNames = array_merge($subCategoryNames, $subProductNames);

            return back()->withErrors(['msg' => $subItemNames]);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with(['success' => "Category `$title` has been removed"]);
    }
}
