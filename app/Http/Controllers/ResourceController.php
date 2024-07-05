<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResourceService;

class ResourceController extends Controller
{

    private $service;

    public function __construct(ResourceService $service){
        $this->service = $service;
    }

    public function cities(Request $request){

        $return = $this->service->cities($request);

        if($return['success']){

            $cities = $return['data'];
            $html = view('admin.components.cities_options')->with(compact('cities'))->render();

            echo json_encode([
                'html' => $html
            ]); die;

        }

    }
}
