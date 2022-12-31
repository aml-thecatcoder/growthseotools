<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;

class YoutubeTrendClass {

	public function get_data($lang, $country, $result)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $client = new Client();

                $client->setDeveloperKey($api_key->google_api_key);

                $youtube = new YouTube($client);

                $value = $youtube->videos->listVideos('snippet', array(
                    'chart'      => 'mostPopular',
                    'maxResults' => $result,
                    'regionCode' => $country,
                    'hl'         => $lang
                ));


                if( count($value['items']) != 0 ) {

                    $data = array();

                    for( $i = 0; $i < count($value['items']); $i++ ){  

                        
                        $data[$i]['thumbnail'] = $value['items'][$i]['snippet']['thumbnails']['default']['url'];

                        $data[$i]['title'] = $value['items'][$i]['snippet']['title'];

                        $data[$i]['link']    = 'https://youtu.be/' . $value['items'][$i]['id'];

                        $data[$i]['tags'] = array();

                        array_push($data[$i]['tags'], $value['items'][$i]['snippet']['tags']);

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