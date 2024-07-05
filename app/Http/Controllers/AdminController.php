<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niche;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    /**
     * Admin panel home
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

        $niches = $company->niches()->where([
            ['status', '=', 1]
        ])->orderby('id', 'DESC')->get();

        $entity = $company->leads()->orderby('id', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        return view('admin.index')->with([
            'total' => $totalQuery,
            'statuses' => $statuses,
            'entity' => $entity,
            'niches' => $niches,
            'perPage' => $perPage,
            'currentPage' => $entity->currentPage(),
            'lastPage' => $entity->lastPage(),
            'from' => $entity->firstItem(),
            'to' => $entity->lastItem(),
        ]);
    } // index()
}
