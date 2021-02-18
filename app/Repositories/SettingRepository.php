<?php

namespace App\Repositories;

use App\Models\Setting as Model;
use App\Models\Setting;


class SettingRepository extends CoreRepository
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
     * Get referral address
     *
     * @param boolean $saveResult
     * @param Setting $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterSaveSetting($saveResult, $item)
    {
        if ($saveResult) {
            return redirect()->route('admin.settings.index')
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }


    /**
     * Get current exchange rate.
     * @return mixed
     */
    public function getExchangeRate()
    {
        $results = $this
            ->startConditions()
            ->select('value')
            ->where('name', 'exchange_rate')
            ->first()['value'];

        return $results;
    }
}
