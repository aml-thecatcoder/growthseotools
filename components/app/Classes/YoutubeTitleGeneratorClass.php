<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;

class YoutubeTitleGeneratorClass {

    public function get_data($query, $country)
    {

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $client = new Client();

                $client->setDeveloperKey($api_key->google_api_key);

                $youtube = new YouTube($client);

                $value = $youtube->search->listSearch('id,snippet', array(
                    'q'          => $query,
                    'maxResults' => 50,
                    'regionCode' => $country
                ));

                if( count($value['items']) != 0 ) {

                    $data = array();

                    $arr = array_rand($value['items'], 10);

                    foreach ($arr as $k => $v) {
                        array_push($data, $value['items'][$v]['snippet']['title']);
                    }

                    return $data;
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
                    return;
                }

                return $data;
                
            } catch (\Exception $e) {

                session()->flash('status', 'error');
                session()->flash('message', __($e->getMessage()));
                return;
            }

        } else{

            session()->flash('status', 'error');
            session()->flash('message', 'Invalid API Keys!');
            return;
        }
    }
    //

}