<?php

namespace App\Http\Controllers;

use App\Models\Niche;
use Illuminate\Http\Request;
use App\Services\NicheService;
use App\Http\Requests\NicheStore;
use App\Http\Requests\NicheEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NicheController extends Controller
{
    private $service;

    public function __construct(NicheService $nicheService)
    {
        $this->service = $nicheService;
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
        
        $totalQuery = $company->niches()->where([
            ['name', 'like', '%' . $search . '%']
        ])
        ->count();

        $entity = $company->niches()->where([
            ['name', 'like', '%' . $search . '%']
        ])->orderby('id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        $html = view('admin.niches.body-table')->with('entity', $entity)->render();

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

        $totalQuery = $company->niches()->get()
        ->count();

        $entity = $company->niches()->orderby('id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        return view('admin.niches.index')->with([
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
        return view('admin.niches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NicheStore $request)
    {
        $return = $this->service->store($request);
        return Redirect::route('niches.index')->with('success', $return);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Niche $niche)
    {
        $user = Auth::user();
        $company = $user->company()->first();
        
        if($company->id == $niche->companyId){
            $entity = $niche;
            return view('admin.niches.show')->with(compact('entity'));
         }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('niches.index')->with('success', $return);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Niche $niche)
    {
        $user = Auth::user();
        $company = $user->company()->first();
        
        if($company->id == $niche->companyId){
            $entity = $niche;
            return view('admin.niches.edit')->with(compact('entity'));
         }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('niches.index')->with('success', $return);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NicheEdit $request, Niche $niche)
    {

        $return = $this->service->update($request, $niche);
        return Redirect::route('niches.edit', $niche->id)->with('success', $return);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Niche $niche)
    {
        $return = $this->service->destroy($niche);
        return Redirect::route('niches.index')->with('success', $return);
    }
}
