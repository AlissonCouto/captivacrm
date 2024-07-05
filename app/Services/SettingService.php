<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Database\QueryException;
use App\Http\Requests\SettingEdit;

class SettingService{

    public function update(SettingEdit $data, Setting $setting){

        try{
            
            $setting->searchType = $data->searchType;
            $setting->messageType = $data->messageType;
            $setting->messageDefault = $data->messageDefault;

            $setting->save();

            return [
                'success' => true,
                'message' => 'Configurações alteradas com sucesso!',
                'data' => $setting
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