<?php

namespace App\Services;

use App\Services\GooglePlacesService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
    
use App\Models\Lead;
use App\Models\City;
use App\Http\Requests\LeadStore;
use App\Http\Requests\LeadEdit;

class LeadService{

    private $googlePlacesService;

    public function __construct(GooglePlacesService $googlePlacesService){

        $this->googlePlacesService = $googlePlacesService;

    }

    /**
     * Displays a list of customers returned by the Google Places API
     */
     public function leadsSearch(Request $data){

        // Buscar na API
        $query = $data->search;
        $return = $this->googlePlacesService->leadsSearch($query);

        $listLeads = [];
        
        if($return['success']){

            $leads = $return['data'];

            if($leads){

                $listLeads = [];

                foreach($leads as $row){

                    $lead = new Lead();

                    $lead->name = $row->name;
                    $lead->slug = Str::slug($row->name);
                    $lead->address = $row->address;
                    $lead->phone = $row->phone;
                    $lead->website = $row->website;
                    $lead->nicheId = $data->nicheId;
                    $lead->status = 1;
                    $lead->companyId = 1;

                    /* Buscando cidade */
                    if($row->state && $row->city){
                        $cityModel = new City();
                        
                        $city = $cityModel->where([
                            ['nome', '=', $row->city],
                            ['uf', '=', $row->state]
                        ])->first();

                        $lead->cityId = $city->id;
                    }

                    $lead->save();

                    $listLeads[] = $lead;

                }

            }

        }

        $return['data'] = $listLeads;

        return $return;

     } // leadsSearch()

     public function store(LeadStore $data){

        try{

            $user = Auth::user();
            $company = $user->company()->first();

            $lead = new Lead();
            $lead->name = $data->name;
            
            $slug = Str::slug($data->name);
            // Verificando se ja existe empresa com o slug
            $slugExist = $company->leads()->where([
                ['slug', 'like', '%' . $slug . '%']
            ])->get();
            $qtdSlugs = count($slugExist);
            
            if ($qtdSlugs >= 1) {
                $slug .= "-" . $qtdSlugs;
            }
            $lead->slug = $slug;

            $lead->phone = $data->phone;
            $lead->address = $data->address;
            $lead->email = $data->email;
            $lead->website = $data->website;
            $lead->lastContact = $data->lastContact;
            $lead->callScheduled = $data->callScheduled;
            $lead->statusId = $data->statusId;
            $lead->nicheId = $data->nicheId;
            $lead->cityId = $data->cityId;
            $lead->status = $data->status;
            $lead->companyId = $user->id;
            $lead->save();

            return [
                'success' => true,
                'message' => 'Lead cadastrado com sucesso!',
                'data' => $lead
            ];

        } catch (\Exception $e) {

            /*switch (get_class($e)) {

                case QueryException::class:
                    return ['success' => false, 'messages' => $e->getMessage()];
                case \ErrorException::class:
                    return ['success' => false, 'messages' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'messages' => $e->getMessage()]];
                default:
                    return ['success' => false, 'messages' => get_class($e)];

                    
            }*/

            return [
                'success' => false,
                'message' => 'Erro ao cadastrar lead!',
                'data' => []
            ]; 
        }

    } // store()

    public function update(LeadEdit $data, Lead $lead){

        try{
            
            $user = Auth::user();
            $company = $user->company()->first();
        
            if($company->id == $lead->companyId){
                
                $lead->name = $data->name;
            
                $slug = Str::slug($data->name);
                // Verificando se ja existe empresa com o slug
                $slugExist = $company->leads()->where([
                    ['slug', 'like', '%' . $slug . '%']
                ])->get();
                $qtdSlugs = count($slugExist);
                
                if ($qtdSlugs >= 1) {
                    $slug .= "-" . $qtdSlugs;
                }
                $lead->slug = $slug;

                $lead->phone = $data->phone;
                $lead->address = $data->address;
                $lead->email = $data->email;
                $lead->website = $data->website;
                $lead->lastContact = $data->lastContact;
                $lead->callScheduled = $data->callScheduled;
                $lead->statusId = $data->statusId;
                $lead->nicheId = $data->nicheId;
                $lead->cityId = $data->cityId;
                $lead->status = $data->status;
                $lead->companyId = $user->id;
                $lead->save();

                return [
                    'success' => true,
                    'message' => 'Lead editado com sucesso!',
                    'data' => $lead
                ];
            }

            $return = ['success' => false, 'message' => 'Você não tem permissão.'];
            return Redirect::route('niches.index')->with('success', $return);

        } catch (\Exception $e) {

            /*switch (get_class($e)) {

                case QueryException::class:
                    return ['success' => false, 'messages' => $e->getMessage()];
                case \ErrorException::class:
                    return ['success' => false, 'messages' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'messages' => $e->getMessage()]];
                default:
                    return ['success' => false, 'messages' => get_class($e)];

                    
            }*/

            return [
                'success' => false,
                'message' => 'Erro ao editar lead!',
                'data' => []
            ]; 
        }

    } // update()

    public function destroy(Lead $lead){

        $user = Auth::user();
        $company = $user->company()->first();

        try{

        if($company->id == $lead->companyId){
            
            $lead->delete();

            return [
                'success' => true,
                'message' => 'Lead deletado com sucesso!',
                'data' => null
            ];

        }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('leads.index')->with('success', $return);

        } catch (\Exception $e) {

            /*switch (get_class($e)) {

                case QueryException::class:
                    return ['success' => false, 'messages' => $e->getMessage()];
                case \ErrorException::class:
                    return ['success' => false, 'messages' => ['file' => $e->getFile(), 'line' => $e->getLine(), 'messages' => $e->getMessage()]];
                default:
                    return ['success' => false, 'messages' => get_class($e)];

                    
            }*/

            return [
                'success' => false,
                'message' => 'Erro ao editar lead!',
                'data' => []
            ]; 
        }

    } // destroy()

}