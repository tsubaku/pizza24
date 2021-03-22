<?php

namespace App\Repositories;

use App\Models\Product as Model;
use App\Models\Product;

use App\Traits\UniqueModelSlug;

class ProductRepository extends CoreRepository
{
    use UniqueModelSlug;

    /**
     * Implementation of an abstract method from CoreRepository
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get a model for editing on the "id" in the admin panel
     *
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }


    /**
     * Get a model for editing on the field "slug" in the admin panel
     *
     * @param string $slug
     * @return Model
     */
    public function getEditSlug($slug)
    {
        return $this->startConditions()->where('slug', $slug)->first();
    }


    /**
     * Get a list of articles to be displayed by the paginator in the list
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'slug', 'category_id', 'description', 'price', 'image_url', 'is_published'];
        $results = $this
            ->startConditions()
            ->select($columns)
            ->orderBy('id', 'ASC')
            //->with(['category', 'user']) //Add a relay for the specified fields to reduce the number of requests

            ->with([
                //1 Way
                ///'category' => function ($query) {       //category () relation is described in the model and for it
                ///$query->select(['id', 'title']);    //the processing should be as follows: 2 fields are needed
                ///},
                //2 Way
                //'user:id,name',//we will refer to the user relation, from which we need id and name
                'category:id,title',//we will refer to the user relation, from which we need id and name
            ])
            ->paginate($perPage);

        return $results;
    }


    /**
     * Get referral address
     *
     * @param boolean $saveResult
     * @param Product $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterSaveProduct($saveResult, $item)
    {
        if ($saveResult) {
            return redirect()->route('admin.products.edit', $item->slug)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }


    /**
     * Get all products in a specified category
     *
     * @param $parentId
     * @return mixed
     */
    public function getSubProducts($parentId)
    {
        $columns = ['title'];
        $results = $this
            ->startConditions()
            ->select($columns)
            ->where('category_id', $parentId)
            ->get();

        return $results;
    }

    /**
     * To form an array of product names
     *
     * @param $parentId
     * @return array
     */
    public function getSubProductsNames($parentId)
    {
        $subProducts = $this->getSubProducts($parentId);
        $subItemNames[] = '⚡️ PRODUCTS:';
        foreach ($subProducts as $subProduct) {
            $subItemNames[] = $subProduct->title;
        }

        return $subItemNames;
    }


    /**
     * Returns the request data. If a picture was passed in the request, it saves it to the store.
     *
     * @param $request
     * @return array
     */
    public function processRequestUpdate($request, $item)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $newFileName = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs(
                'public', $newFileName
            );
            $data['image_url'] = $newFileName;
        }


      //  dd($request->slug);
        //dd($item->getKeyName(), '!=', $item->getKey());
      //  dd($item->where($item->getKeyName(), '!=', $item->getKey()));
    //    if ($data['slug'] === null) {
   //         $data['slug'] ='1';
   //     }
        $data['slug'] = $this->generateSlug(
            $item, // указываем модель экземпляром, т.к. обновляем существующую строку
            //$data['slug']
            $request->slug
        ); // 1-blog

        return $data;
    }

}
