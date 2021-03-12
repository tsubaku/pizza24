<?php

namespace App\Repositories;

use App\Models\Category as Model;
use Illuminate\Database\Eloquent\Collection;

//use Illuminate\Pagination\LengthAwarePaginator;
//use PhpParser\Node\Expr\AssignOp\Concat;

class CategoryRepository extends CoreRepository
{
    /**
     * Implementation of an abstract method from CoreRepository
     *
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get a model for editing in the admin panel
     * @param $id
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
     * Get categories for display by paginator
     *
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'slug', 'parent_id', 'image_url'];
        $results = $this
            ->startConditions()
            ->select($columns)
            //->with([
            //    'parentCategory:id,title', //load relation with two fields
            //])
            ->paginate($perPage);
        //$results = $this
        //    ->startConditions()
        //    ->paginate($perPage, $columns);
        return $results;
    }


    /**
     * Get a list of categories to display in a dropdown list
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = ['id', 'title', 'slug'];
        $result = $this
            ->startConditions()
            ->select($columns)
            ->toBase()
            ->get();

        return $result;
    }


    /**
     * Get referral address
     *
     * @param boolean $saveResult
     * @param Category $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterSaveCategory($saveResult, $item)
    {
        if ($saveResult) {
            return redirect()->route('admin.categories.edit', $item->slug)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }


    /**
     * Get all subcategories of a specified category.
     *
     * @param $parentId
     * @return mixed
     */
    public function getSubCategories($parentId)
    {
        $columns = ['title'];
        $results = $this
            ->startConditions()
            ->select($columns)
            ->where('parent_id', $parentId)
            ->get();

        return $results;
    }

    /**
     * To form an array of category names
     *
     * @param $parentId
     * @return array
     */
    public function getSubCategoriesNames($parentId)
    {
        $subCategories = $this->getSubCategories($parentId);
        $subItemNames[] = '⚡️⚡️ A given category has subcategories and/or products under it. Delete them first.';
        $subItemNames[] = '⚡️ SUBCATEGORIES:';
        foreach ($subCategories as $subCategory) {
            $subItemNames[] = $subCategory->id . ' ' . $subCategory->title;
        }

        return $subItemNames;
    }


}
