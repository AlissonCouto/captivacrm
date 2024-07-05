<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Database\QueryException;
use App\Http\Requests\SettingEdit;

class ResourceService{

    public function cities(Request $data){

        try{
            
            $cities = City::where('uf', $data->uf)->orderby('nome', 'ASC')->get();

            return [
                'success' => true,
                'message' => 'Cidades retornadas com sucesso!',
                'data' => $cities
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
                'message' => 'Erro ao alterar configurações!',
                'data' => []
            ]; 
        }

    } // update

}