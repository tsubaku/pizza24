<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

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
        $this->model = app($this->getModelClass()); //creation through the service provider
        //$this->model = new $this->getModelClass(); //analogue
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

}
