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
     * Get categories for display by paginator
     *
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id', 'image_url'];
        $results = $this
            ->startConditions()
            ->select($columns)
            //->with([
            //    'parentCategory:id,title', //load relation with two fields
            //])
            ->paginate($perPage);
        //$results = $this
        //    ->startConditions()
        //    ->paginate($perPage, $columns); //the paginator can also work with the specified columns
        return $results;
    }


    /**
     * Get a list of categories to display in a dropdown list
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'title',
        ]);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
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
            return redirect()->route('admin.categories.edit', $item->id)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }


}
