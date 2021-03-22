<?php

namespace App\Repositories;

use App\Models\Product as Model;
use Cookie;
use Illuminate\Http\Request; //?


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
     * @param  float $exchangeRate
     * @param  int $cartId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getWithPaginate($perPage, $selected, $exchangeRate, $cartId)
    {
        #If a category is specified and it is NOT root, then the category is checked
        if ($selected <= 1) {
            $checkType = '<>';
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
                'category:id,title',//we will refer to the category relation
                'cartItem' => function ($query) use ($cartId) {
                    $query->where('cart_id', $cartId)->select(['product_id', 'quantity']);
                }
            ])
            ->paginate($perPage);

        return $results;
    }




    ###############

    /**
     * Get session id from Cookie. If not, then install from session
     *
     * @param Request $request
     * @return string
     */
    public function getSessionId($request)
    {
        $sessionId = $request->cookie(self::NAME_COOKIE_SESSION);
        if (empty($sessionId)) {
            $sessionId = $this->setSessionId();
        }

        return $sessionId;
    }

    /**
     * Get Session id from session and set Cookies
     *
     * @return string
     */
    public function setSessionId()
    {
        $sessionId = session()->getId();
        Cookie::queue(self::NAME_COOKIE_SESSION, $sessionId, self::COOKIE_LIFE_TIME);
        Cookie::queue(self::NAME_COOKIE_CURRENCY, self::EUR_NAME_CURRENCY, self::COOKIE_LIFE_TIME);
        Cookie::queue(self::NAME_COOKIE_LOCALE, self::DEFAULT_LOCALE, self::COOKIE_LIFE_TIME);

        return $sessionId;
    }

    /**
     * Get Currency name from cookie
     *
     * @return string
     */
    public function getCurrencyName($request)
    {
        $currencyName = $request->cookie(self::NAME_COOKIE_CURRENCY);

        return $currencyName;
    }

    /**
     * Get logo currecy.
     *
     * @param string $currencyName
     * @return string
     */
    public function getCurrencyLogo($currencyName)
    {
        if ($currencyName === self::USD_NAME_CURRENCY) {
            $currencyLogo = self::USD_LOGO_CURRENCY;
        } else {
            $currencyLogo = self::EUR_LOGO_CURRENCY;
        }

        return $currencyLogo;
    }


    /**
     * Get user exchange rate.
     *
     * @param string $currencyName
     * @return int|mixed
     */
    public function getCurrentExchangeRate($currencyName)
    {
        if ($currencyName === self::USD_NAME_CURRENCY) {
            $exchangeRate = $this->getExchangeRate();
        } else {
            $exchangeRate = 1;
        }

        return $exchangeRate;
    }


    /**
     * Set user locale
     *
     * @param $rawLocale
     * @return bool
     */
    public function setLocale($locale)
    {
        Cookie::queue(self::NAME_COOKIE_LOCALE, $locale, self::COOKIE_LIFE_TIME);

        return true;
    }


}
