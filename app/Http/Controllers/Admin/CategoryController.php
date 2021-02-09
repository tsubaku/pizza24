<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
//use Illuminate\Http\Request;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\CategoryCreateRequest;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
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
        $data = $request->input();

        #Create and save to db object
        //1 Way
        $item = new Category($data);
        $saveResult = $item->save();

        //2 Way  through the laravel builder
        //$item = (new Category())->create($data);

        //3 Way
        //$item = Category::create($data);

        $goTo = $this->categoryRepository->goAfterSaveCategory($saveResult, $item);

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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->categoryRepository->getEdit($id);
        // dd($item);
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
        $item = $this->categoryRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Category id=$id not found"])
                ->withInput();
        }
        $data = $request->all();

        $saveResult = $item
            ->fill($data)
            ->save();       //запись в бд

        $goTo = $this->categoryRepository->goAfterSaveCategory($saveResult, $item);

        return $goTo;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Soft removal, remains in the database
        $result = Category::destroy($id);//в $result попадёт кол-во удалённых записей

        //Complete removal from the database
        //$result = Post::find($id)->forceDelete();

        if ($result) {
            return redirect()
                ->route('admin.categories.index')
                ->with(['success' => "Category $id has been removed."]);
        } else {
            return back()->withErrors(['msg' => 'Delete error']);
        }
    }
}
