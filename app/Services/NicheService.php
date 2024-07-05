<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Niche;
use Illuminate\Database\QueryException;
use App\Http\Requests\NicheStore;
use App\Http\Requests\NicheEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class NicheService{

    public function store(NicheStore $data){

        try{
            
            $user = Auth::user();
            $company = $user->company()->first();

            $niche = new Niche();
            $niche->name = $data->name;
            
            $slug = Str::slug($data->name);
            // Verificando se ja existe empresa com o slug
            $slugExist = $company->niches()->where([
                ['slug', 'like', '%' . $slug . '%']
            ])->get();
            $qtdSlugs = count($slugExist);
            
            if ($qtdSlugs >= 1) {
                $slug .= "-" . $qtdSlugs;
            }
            $niche->slug = $slug;
            $niche->color = $data->color;
            $niche->status = $data->status;
            $niche->companyId = $user->id;
            $niche->save();

            return [
                'success' => true,
                'message' => 'Nicho cadastrado com sucesso!',
                'data' => $niche
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
                'message' => 'Erro ao cadastrar nicho!',
                'data' => []
            ]; 
        }

    } // store

    public function update(NicheEdit $data, Niche $niche){

        try{
            
            $user = Auth::user();
            $company = $user->company()->first();
        
            if($company->id == $niche->companyId){
                $niche->name = $data->name;
                
                $slug = Str::slug($data->name);
                // Verificando se ja existe empresa com o slug
                $slugExist = $company->niches()->where([
                    ['slug', 'like', '%' . $slug . '%']
                ])->get();
                $qtdSlugs = count($slugExist);
                if ($qtdSlugs >= 1) {
                    $slug .= "-" . $qtdSlugs;
                }
                $niche->slug = $slug;
                $niche->color = $data->color;
                $niche->status = $data->status;
                $niche->save();

                return [
                    'success' => true,
                    'message' => 'Nicho editado com sucesso!',
                    'data' => $niche
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
                'message' => 'Erro ao editar nicho!',
                'data' => []
            ]; 
        }

    } // update()

    public function destroy(Niche $niche){

        $user = Auth::user();
        $company = $user->company()->first();

        try{

        if($company->id == $niche->companyId){
            
            $niche->delete();

            return [
                'success' => true,
                'message' => 'Nicho deletado com sucesso!',
                'data' => null
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
                'message' => 'Erro ao editar nicho!',
                'data' => []
            ]; 
        }

    } // destroy()

}