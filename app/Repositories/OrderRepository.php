<?php

namespace App\Repositories;

use App\Models\Order as Model;

//use Illuminate\Database\Eloquent\Collection;
//use Illuminate\Pagination\LengthAwarePaginator;
//use PhpParser\Node\Expr\AssignOp\Concat;

//use App\Http\Requests\OrderUpdateRequest;
//use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;

class OrderRepository extends CoreRepository
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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($sessionId, $perPage = null)
    {
        $columns = ['id', 'user_id', 'session_id', 'status', 'total', 'currency', 'name', 'email', 'phone', 'address', 'created_at'];
        $results = $this
            ->startConditions()
            ->select($columns)
            ->orderBy('created_at', 'DESC')
            ->where('session_id', $sessionId)
            ->paginate($perPage);

        return $results;
    }


}
