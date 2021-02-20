<?php

namespace App\Repositories;

use App\Models\Product as Model;
use App\Models\Product;


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
    public function getWithPaginate($perPage = null, $selected = null, $exchangeRate = null )
    {

        #If a category is specified and it is NOT root, then the category is checked
        if ($selected <= 1) {
            $checkType  = '<>';
            $selected = 0;
        } else {
            $checkType = '=';
        }

        #Get data
        $results = $this
            ->startConditions()
            ->select('id', 'title', 'slug', 'category_id', 'description', 'image_url',
                \DB::raw("ROUND((price / $exchangeRate),2) AS price"))
            ->where('is_published', 1)
            ->where('category_id', $checkType, $selected)
            ->orderBy('id', 'ASC')
            ->with([
                'category:id,title',//we will refer to the user relation, from which we need id and name
            ])
            ->paginate($perPage);

        return $results;
    }

}
