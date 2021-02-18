<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests\SettingUpdateRequest;
use App\Repositories\SettingRepository;

class SettingController extends Controller
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->settingRepository = app(SettingRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allSettings = Setting::all();
        return view('admin.settings.index', compact('allSettings'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingUpdateRequest $request, $id)
    {
        $item = $this->settingRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Setting id=$id not found"])
                ->withInput();
        }

        $data = $request->all();
        $saveResult = $item->update($data);//writing in DB
        $goTo = $this->settingRepository->redirectAfterSaveSetting($saveResult, $item);

        return $goTo;
    }


}
