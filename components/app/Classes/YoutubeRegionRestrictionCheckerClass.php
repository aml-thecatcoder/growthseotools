<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;

class YoutubeRegionRestrictionCheckerClass {

	public function get_data($link)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $link, $videoId);

                if ( $check ) {

                    $sst = new SSTClass();

                    $source = $sst->url_get_contents( 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails,snippet&id='.$videoId[1].'&key=' . $api_key->google_api_key );

                    $deJson = json_decode( $source, true );
                    
                    if( count($deJson['items'][0]['snippet']) != 0 ) {

                        $data = array();

                        $data['video_id'] = $videoId[1];

                        $data['title'] = !empty( $deJson['items'][0]['snippet']['title'] ) ? $deJson['items'][0]['snippet']['title'] : 'None';

                        $data['allowed'] = !empty( $deJson['items'][0]['contentDetails']['regionRestriction']['allowed'] ) ? $deJson['items'][0]['contentDetails']['regionRestriction']['allowed'] : false;

                        $data['blocked'] = !empty( $deJson['items'][0]['contentDetails']['regionRestriction']['blocked'] ) ? $deJson['items'][0]['contentDetails']['regionRestriction']['blocked'] : false;

                        return $data;
                    } 
                    else{

                        session()->flash('status', 'error');
                        session()->flash('message', __('No Result Found!'));
                        return;
                    }

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