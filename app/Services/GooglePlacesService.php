<?php

    namespace App\Services;

    use GuzzleHttp\Client;

    class GooglePlacesService{

        private $client;
        private $url;
        private $apiKey;

        public function __construct(){

            $this->client = new Client();
            $this->apiKey = "AIzaSyDw8v0KY3_qUQg-hTDwLpdD_JnIekstoFU";

        }

        function getCityAndState($addressComponents) {
            $city = '';
            $state = '';
            foreach ($addressComponents as $component) {
                if (in_array('administrative_area_level_2', $component['types'])) {
                    $city = $component['long_name'];
                }
                if (in_array('administrative_area_level_1', $component['types'])) {
                    $state = $component['short_name'];
                }
            }
            return [$city, $state];
        }

        public function leadsSearch($query){

            $this->url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=' . urlencode($query) . '&key=' . $this->apiKey;

            $response = $this->client->request('GET', $this->url);
            $status = $response->getStatusCode();
            $body = $response->getBody();
            $data = json_decode($body, true);

            $places = [];
            $leads = [];
            
            if($status == 200){

                $places = isset($data['results']) ? $data['results'] : null;
                
                if($places){
                    
                    // Buscar detalhes dos Leads
                    foreach($places as $place){

                        $placeId = $place['place_id'];

                        $detailsUrl = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $placeId . '&fields=name,formatted_address,formatted_phone_number,website,address_component,types&key=' . $this->apiKey;

                        $detailsResponse = $this->client->request('GET', $detailsUrl);
                        $detailsBody = $detailsResponse->getBody();
                        $details = json_decode($detailsBody, true);

                        $result = $details['result'];
                        if($result){

                            list($city, $state) = $this->getCityAndState($result['address_components']);

                            $lead = new \stdClass();

                            $lead->name = $result['name'];
                            $lead->address = $result['formatted_address'];
                            $lead->phone = (isset($result['formatted_phone_number']) ? $result['formatted_phone_number'] : null);
                            $lead->website = (isset($result['website']) ? $result['website'] : null);
                            $lead->city = $city;
                            $lead->state = $state;
                            
                            $leads[] = $lead;

                        }

                    }

                }

                return [
                    'success' => true,
                    'message' => 'Leads retornados com sucesso!',
                    'data' => $leads
                ];

            }else{
                return [
                    'success' => false,
                    'message' => 'Algo deu errado na busca.',
                    'data' => $data['error_message'],
                ];
            }

        } // leadsSearch()
        
    }