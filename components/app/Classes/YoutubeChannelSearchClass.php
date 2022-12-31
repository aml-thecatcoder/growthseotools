<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;

class YoutubeChannelSearchClass {

	public function get_data($query, $country, $result)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $client = new Client();

                $client->setDeveloperKey($api_key->google_api_key);

                $youtube = new YouTube($client);
                
                $value = $youtube->search->listSearch('snippet', array(
                    'q'          => $query,
                    'type'       => 'channel',
                    'regionCode' => $country,
                    'maxResults' => $result
                ));

                if( count($value['items']) != 0 ) {

                    foreach ($value['items'] as $k => $v) {

                        $data[$k]['channelId']    = isset( $v['snippet']['channelId'] ) ? $v['snippet']['channelId'] : 'None';

                        $data[$k]['channelTitle'] = isset( $v['snippet']['channelTitle'] ) ? $v['snippet']['channelTitle'] : 'None';

                        $data[$k]['thumbnail']    = isset( $v['snippet']['thumbnails']['default']['url'] ) ? $v['snippet']['thumbnails']['default']['url'] : asset('assets/img/no-thumb.svg');

                        $data[$k]['publishedAt']  = isset( $v['snippet']['publishedAt'] ) ? $v['snippet']['publishedAt'] : 'None';

                    }

                    return $data;
                } 
                else{

                    session()->flash('status', 'error');
                    session()->flash('message', __('No Result Found!'));
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