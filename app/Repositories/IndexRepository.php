<?php

namespace App\Repositories;

use App\Models\Product as Model;


class IndexRepository extends CoreRepository
{
    /**
     * Implementation of an abstract method from CoreRepository
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get a model for editing in the admin panel
     *
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }


    /**
     * Get a list of articles to be displayed by the paginator in the list
     *
     * @param  int $perPage
     * @param  int $selected
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getWithPaginate($perPage = null, $selected = null)
    {
        $columns = ['id', 'title', 'slug', 'category_id', 'description', 'price', 'image_url'];

        #if a category is specified and it is NOT root, then the category is checked
        if ($selected <= 1) {
            $b = '<>';
            $selected = 0;
        } else {
            $b = '=';
        }
        $results = $this
            ->startConditions()
            ->select($columns)
            ->where('is_published', 1)
            ->where('category_id', $b, $selected)
            ->orderBy('id', 'ASC')
            ->with([
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
            return redirect()->route('admin.products.edit', $item->id)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }


}
