<?php

namespace App\Repositories;

use App\Models\Product as Model;

//use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Pagination\LengthAwarePaginator;
//use PhpParser\Node\Expr\AssignOp\Concat;

class ProductRepository extends CoreRepository
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
          ///      'category' => function ($query) {       //category () relation is described in the model and for it
         ///           $query->select(['id', 'title']);    //the processing should be as follows: 2 fields are needed

         ///       },
                //2 Way
               // 'user:id,name',//we will refer to the user relation, from which we need id and name
                'category:id,title',//we will refer to the user relation, from which we need id and name
            ])
            ->paginate($perPage);

        return $results;
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

}
