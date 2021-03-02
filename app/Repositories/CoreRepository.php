<?php

namespace App\Repositories;

use App\Models\Setting;
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
    const EUR_NAME_CURRENCY = 'EUR';

    const NAME_COOKIE_SESSION = 'session';
    const COOKIE_LIFE_TIME = 2628000; //5 year
    const NAME_COOKIE_CURRENCY = 'currency';

    const USD_LOGO_CURRENCY = '$ ';
    const EUR_LOGO_CURRENCY = '€ ';

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
     * Get the Cart id (if exist) or 0 (if not exist)
     *
     * @param  string $fieldName
     * @param  string $fieldValue
     * @param  Collection $model
     * @return int
     */
    /*
    public function getCartId($fieldName, $fieldValue, $model)
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
    */

    /**
     * Get current exchange rate.
     * @return mixed
     */
    public function getExchangeRate()
    {
        $results = Setting::select('value')
            ->where('name', 'exchange_rate')
            ->first()['value'];

        return $results;
    }
}
