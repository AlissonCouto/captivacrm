<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SettingService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SettingEdit;

class SettingController extends Controller
{

    private $service;

    public function __construct(SettingService $service){

        $this->service = $service;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        $setting = $user->company()->first()->setting()->first();

        if($setting){
            return view('admin.settings.edit')->with(compact('setting'));
        }

        return Redirect::route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingEdit $request)
    {
        $user = Auth::user();

        $setting = $user->company()->first()->setting()->first();

        if($setting){
            $return = $this->service->update($request, $setting);
        }

        $session = ['success' => $return['success'], 'message' => $return['message']];
        return Redirect::route('settings.edit')->with('success',$session);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
