<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusStore;
use App\Http\Requests\StatusEdit;
use App\Services\StatusService;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StatusController extends Controller
{

    private $service;

    public function __construct(StatusService $statusService)
    {
        $this->service = $statusService;
    }

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

        $perPage = 10; // Número de itens por página
        $page = $request->get('page', 1); // Pega o número da página da requisição, padrão é 1
        
        $totalQuery = $company->statuses()->where([
            ['name', 'like', '%' . $search . '%']
        ])
        ->count();

        $entity = $company->statuses()->where([
            ['name', 'like', '%' . $search . '%']
        ])->orderby('id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        $html = view('admin.statuses.body-table')->with('entity', $entity)->render();

        echo json_encode([
            'total' => $totalQuery,
            'perPage' => $perPage,
            'currentPage' => $entity->currentPage(),
            'lastPage' => $entity->lastPage(),
            'from' => $entity->firstItem(),
            'to' => $entity->lastItem(),
            'html' => $html
        ]); die;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $company = $user->company()->first();

        $perPage = 10; // Número de itens por página
        $page = $request->get('page', 1); // Pega o número da página da requisição, padrão é 1

        $totalQuery = $company->statuses()->get()
        ->count();

        $entity = $company->statuses()->orderby('id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        return view('admin.statuses.index')->with([
            'total' => $totalQuery,
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
        return view('admin.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusStore $request)
    {
        $return = $this->service->store($request);
        return Redirect::route('statuses.index')->with('success', $return);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        $user = Auth::user();
        $company = $user->company()->first();
        
        if($company->id == $status->companyId){
            $entity = $status;
            return view('admin.statuses.show')->with(compact('entity'));
         }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('statuses.index')->with('success', $return);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Status $status)
    {
        $user = Auth::user();
        $company = $user->company()->first();
        
        if($company->id == $status->companyId){
            $entity = $status;
            return view('admin.statuses.edit')->with(compact('entity'));
         }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('statuses.index')->with('success', $return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusEdit $request, Status $status)
    {

        $return = $this->service->update($request, $status);
        return Redirect::route('statuses.edit', $status->id)->with('success', $return);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $return = $this->service->destroy($status);
        return Redirect::route('statuses.index')->with('success', $return);
    }
}
