<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

use App\Services\LeadService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LeadStore;
use App\Http\Requests\LeadEdit;
use App\Models\State;
use App\Models\City;

class LeadController extends Controller
{

    private $service;

    public function __construct(LeadService $service)
    {

        $this->service = $service;
    }

    /**
     * Displays a list of customers returned by the Google Places API
     */
    public function leadsSearch(Request $request)
    {

        $return = $this->service->leadsSearch($request);

        $session = ['status' => $return['success'], 'message' => $return['message']];

        if ($session['status']) {
            return Redirect::route('leads.message')->with([
                'session' => $session,
                'leads' => $return['data']
            ]);
        }

        return Redirect::route('dashboard')->with('success', $session);
    } // leadsSearch()

    /**
     * Mostrar listagem de leads retornado pela Google Places API
     */
    public function leadsMessage()
    {

        $session = session('session');
        $leads = session('leads');

        if ($leads) {

            return view('leads-message')->with([
                'session' => $session,
                'leads' => $leads
            ]);
        }

        return Redirect::route('dashboard')->with('success', $session);
    } // leadsMessage()

    /**
     * Display a listing of the resource through query.
     */
    public function search(Request $request)
    {

        $search = $request->search;
        $search = $request->search ? $request->search : '';
        //dd($request->query());
        $user = Auth::user();
        $company = $user->company()->first();

        /* Filtros */
        $withWhatsapp = $request->withWhatsapp;
        $status = $request->status;
        $lastContact = $request->lastContact;
        $callScheduled = $request->callScheduled;
        $created_at = $request->created_at;

        $where[] = ['name', 'like', '%' . $search . '%'];

        if ($withWhatsapp) {
            $where[] = ['phone', 'IS NOT', NULL];
        }

        if ($status) {
            $where[] = ['statusId', '=', $status];
        }

        if ($lastContact) {
            $where[] = ['lastContact', 'like', '%' . $lastContact . '%'];
        }

        if ($callScheduled) {
            $where[] = ['callScheduled', 'like', '%' . $callScheduled . '%'];
        }

        if ($created_at) {
            $where[] = ['created_at', 'like', '%' . $created_at . '%'];
        }

        /* Filtros */

        $perPage = 10; // Número de itens por página
        $page = $request->get('page', 1); // Pega o número da página da requisição, padrão é 1

        $totalQuery = $company->leads()->where($where)
            ->count();

        $entity = $company->leads()->where($where)->orderby('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $html = view('admin.leads.body-table')->with('entity', $entity)->render();

        echo json_encode([
            'total' => $totalQuery,
            'perPage' => $perPage,
            'currentPage' => $entity->currentPage(),
            'lastPage' => $entity->lastPage(),
            'from' => $entity->firstItem(),
            'to' => $entity->lastItem(),
            'html' => $html
        ]);
        die;
    } // search()

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company()->first();

        $statuses = $company->statuses()->orderby('id', 'desc')->get();

        $perPage = 10; // Número de itens por página
        $page = $request->get('page', 1); // Pega o número da página da requisição, padrão é 1

        $totalQuery = $company->leads()->get()
            ->count();

        $entity = $company->leads()->orderby('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return view('admin.leads.index')->with([
            'total' => $totalQuery,
            'statuses' => $statuses,
            'entity' => $entity,
            'perPage' => $perPage,
            'currentPage' => $entity->currentPage(),
            'lastPage' => $entity->lastPage(),
            'from' => $entity->firstItem(),
            'to' => $entity->lastItem(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $company = $user->company()->first();

        $statuses = $company->statuses()->orderby('name', 'ASC')->get();
        $niches = $company->niches()->orderby('name', 'ASC')->get();

        $states = State::orderby('name', 'ASC')->get();
        $cities = City::where('uf', $states[0]->uf)->orderby('nome', 'ASC')->get();

        return view('admin.leads.create')->with(compact('statuses', 'niches', 'states', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadStore $request)
    {
        $return = $this->service->store($request);
        return Redirect::route('leads.index')->with('success', $return);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        $user = Auth::user();
        $company = $user->company()->first();

        if ($company->id == $lead->companyId) {
            $entity = $lead;
            return view('admin.leads.show')->with(compact('entity'));
        }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('leads.index')->with('success', $return);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Lead $lead)
    {
        $user = Auth::user();
        $company = $user->company()->first();

        if ($company->id == $lead->companyId) {
            $entity = $lead;

            $statuses = $company->statuses()->orderby('name', 'ASC')->get();
            $niches = $company->niches()->orderby('name', 'ASC')->get();

            $states = State::orderby('name', 'ASC')->get();

            if ($lead->cityId) {
                $city = City::find($lead->cityId);
            }

            $stateUf = isset($city) ? $city->uf : $states[0]->uf;
            $cities = City::where('uf', $stateUf)->orderby('nome', 'ASC')->get();

            return view('admin.leads.edit')->with(compact('entity', 'statuses', 'niches', 'states', 'cities', 'city'));
        }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('leads.index')->with('success', $return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadEdit $request, Lead $lead)
    {

        $return = $this->service->update($request, $lead);
        return Redirect::route('leads.edit', $lead->id)->with('success', $return);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $return = $this->service->destroy($lead);
        return Redirect::route('leads.index')->with('success', $return);
    }
}
