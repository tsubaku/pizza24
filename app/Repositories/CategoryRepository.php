<?php

namespace App\Repositories;

use App\Models\Category as Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Concat;

class CategoryRepository extends CoreRepository
{

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
     * Get a list of categories to display in a dropdown list
     *
     * @return Collection
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS idTitle',
        ]);

        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }


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
     * Get categories for display by paginator
     *
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];
        $results = $this
            ->startConditions()
            ->select($columns)
            //->with([
            //    'parentCategory:id,title', //подгрузить релейшен с двумя полями
            //])
            ->paginate($perPage);
        //$results = $this
        //    ->startConditions()
        //    ->paginate($perPage, $columns); //пагинатор может так же работать с указнными столбцами
        return $results;
    }


    /**
     * Get referral address
     *
     * @param boolean $saveResult
     * @param Category $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function goAfterSaveCategory($saveResult, $item)
    {
        if ($saveResult) {
            return redirect()->route('admin.categories.edit', $item->id)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }

}
