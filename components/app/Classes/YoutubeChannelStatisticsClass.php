<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;

class YoutubeChannelStatisticsClass {

	public function get_data($link)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $sst = new SSTClass();

                $response = $sst->url_get_contents($link);

                preg_match('/"browseId":"(.*?)"/', $response, $channelId);

                if( !empty($channelId[1]) ) {

                    $source = $sst->url_get_contents( 'https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id='.$channelId[1].'&key=' . $api_key->google_api_key );

                    $deJson = json_decode( $source, true );

                    if( count($deJson['items'][0]['snippet']) != 0 ) {

                        $data['channelId'] = isset( $deJson['items'][0]['id'] ) ? $deJson['items'][0]['id'] : 0;

                        $data['channelTitle'] = isset( $deJson['items'][0]['snippet']['title'] ) ? $deJson['items'][0]['snippet']['title'] : 0;

                        $data['description'] = isset( $deJson['items'][0]['snippet']['description'] ) ? $deJson['items'][0]['snippet']['description'] : 0;

                        $data['publishedAt'] = isset( $deJson['items'][0]['snippet']['publishedAt'] ) ? $deJson['items'][0]['snippet']['publishedAt'] : 0;

                        $data['thumbnail'] = isset( $deJson['items'][0]['snippet']['thumbnails']['default']['url'] ) ? $deJson['items'][0]['snippet']['thumbnails']['default']['url'] : asset('assets/img/no-thumb.svg');

                        $data['country'] = isset( $deJson['items'][0]['snippet']['country'] ) ? $deJson['items'][0]['snippet']['country'] : 0;

                        $data['viewCount'] = !empty( $deJson['items'][0]['statistics']['viewCount'] ) ? $deJson['items'][0]['statistics']['viewCount'] : 0;

                        $data['subscriberCount'] = !empty( $deJson['items'][0]['statistics']['subscriberCount'] ) ? $deJson['items'][0]['statistics']['subscriberCount'] : 0;

                        $data['videoCount'] = !empty( $deJson['items'][0]['statistics']['videoCount'] ) ? $deJson['items'][0]['statistics']['videoCount'] : 0;

                        return $data;
                    
                    } 
                    else{

                        session()->flash('status', 'error');
                        session()->flash('message', __('No Result Found!'));
                        return;
                    }

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