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


}
