<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Status;
use Illuminate\Database\QueryException;
use App\Http\Requests\StatusStore;
use App\Http\Requests\StatusEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class StatusService{

    public function store(StatusStore $data){

        try{
            
            $user = Auth::user();
            $company = $user->company()->first();

            $status = new Status();
            $status->name = $data->name;
            
            $slug = Str::slug($data->name);
            // Verificando se ja existe empresa com o slug
            $slugExist = $company->statuses()->where([
                ['slug', 'like', '%' . $slug . '%']
            ])->get();
            $qtdSlugs = count($slugExist);
            
            if ($qtdSlugs >= 1) {
                $slug .= "-" . $qtdSlugs;
            }
            $status->slug = $slug;
            $status->color = $data->color;
            $status->status = $data->status;
            $status->companyId = $user->id;
            $status->save();

            return [
                'success' => true,
                'message' => 'Status cadastrado com sucesso!',
                'data' => $status
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
                'message' => 'Erro ao cadastrar status!',
                'data' => []
            ]; 
        }

    } // store

    public function update(StatusEdit $data, Status $status){

        try{
            
            $user = Auth::user();
            $company = $user->company()->first();
        
            if($company->id == $status->companyId){
                $status->name = $data->name;
                
                $slug = Str::slug($data->name);
                // Verificando se ja existe empresa com o slug
                $slugExist = $company->statuses()->where([
                    ['slug', 'like', '%' . $slug . '%']
                ])->get();
                $qtdSlugs = count($slugExist);
                if ($qtdSlugs >= 1) {
                    $slug .= "-" . $qtdSlugs;
                }
                $status->slug = $slug;
                $status->color = $data->color;
                $status->status = $data->status;
                $status->save();

                return [
                    'success' => true,
                    'message' => 'Status editado com sucesso!',
                    'data' => $status
                ];
            }

            $return = ['success' => false, 'message' => 'Você não tem permissão.'];
            return Redirect::route('statuses.index')->with('success', $return);

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
                'message' => 'Erro ao editar status!',
                'data' => []
            ]; 
        }

    } // update()

    public function destroy(Status $status){

        $user = Auth::user();
        $company = $user->company()->first();

        try{

        if($company->id == $status->companyId){
            
            $status->delete();

            return [
                'success' => true,
                'message' => 'Status deletado com sucesso!',
                'data' => null
            ];

        }

        $return = ['success' => false, 'message' => 'Você não tem permissão.'];
        return Redirect::route('statuses.index')->with('success', $return);

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
                'message' => 'Erro ao editar status!',
                'data' => []
            ]; 
        }

    } // update()

}