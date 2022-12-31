<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;

class YoutubeTitleExtractorClass {

	public function get_data($link)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $client = new Client();

                $client->setDeveloperKey($api_key->google_api_key);

                $youtube = new YouTube($client);

                $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $link, $videoId);

                if ( $check ) {

                    $value = $youtube->videos->listVideos('snippet', array(
                        'id' => $videoId[1]
                    ));

                    if( !empty($value['items'][0]['snippet']['title'])) {

                        $data = $value['items'][0]['snippet']['title'];
                    } 
                    else{

                        session()->flash('status', 'error');
                        session()->flash('message', __('No Result Found!'));
                        return;
                    }

                    return $data;

                } else {

                    session()->flash('status', 'error');
                    session()->flash('message', __('Invalid Video URL!'));
                    return;
                }
                
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