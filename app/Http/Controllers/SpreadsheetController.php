<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Services\SpreadSheetService;

use App\Models\Niche;
use App\Models\City;

class SpreadsheetController extends Controller
{

    private $service;

    public function __construct(SpreadSheetService $spreadSheet)
    {
        $this->service = $spreadSheet;
    }

    public function create()
    {

        $niches = Niche::where('status', 1)->orderby('name', 'ASC')->get();
        $cities = City::where('id_estado', 1)->orderby('nome', 'ASC')->get();

        return view('admin.leads.spreadsheet.create')->with(compact('niches', 'cities'));
    } // create()

    public function store(Request $request)
    {
        $return = $this->service->store($request);

        if ($return['success']) {
            return Redirect::route('leads.index')->with('success', $return);
        }

        return Redirect::route('leads.spreadsheet.upload')->with('success', $return);
    } // store()
}
