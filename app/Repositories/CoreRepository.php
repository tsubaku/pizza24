<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class CoreRepository
 *
 * @package App\Repositories
 */
abstract class CoreRepository
{
    const PICTURES_NOT_AVAILABLE = 'not-available.png';
    const USD_NAME_CURRENCY = 'USD';

    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass()); //creation through the service provider.
        //$this->model = new $this->getModelClass(); //analogue.
    }


    /**
     *
     * @return mixed
     */
    abstract protected function getModelClass();

    protected function startConditions()
    {
        return clone $this->model;
    }


    /**
     * Returns the request data. If a picture was passed in the request, it saves it to the store.
     *
     * @param $request
     * @return array
     */
    public function processRequest($request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $newFileName = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs(
                'public', $newFileName
            );
            $data['image_url'] = $newFileName;
        } else {
            $data['image_url'] = $this::PICTURES_NOT_AVAILABLE;
        }

        return $data;
    }

    /**
     * Get Cart id (if exist) or 0 (if not exist)
     *
     * @param  string $fieldName
     * @param  string $fieldValue
     * @param  Collection $model
     * @return int
     */
    public function getItemId($fieldName, $fieldValue, $model)
    {
        $result = $model->where($fieldName, $fieldValue)->isNotEmpty();
        if ($result) {
            $result = $model->where($fieldName, $fieldValue)->first();
            $itemId = $result->id;
        } else {
            $itemId = 0;
        }
        return $itemId;
    }

}
