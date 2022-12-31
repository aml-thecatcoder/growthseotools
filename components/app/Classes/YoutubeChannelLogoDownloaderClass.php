<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;
use App\Models\Admin\General;

class YoutubeChannelLogoDownloaderClass {

    public function get_data($link)
    {

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $sst = new SSTClass();

                $response = $sst->url_get_contents($link);

                preg_match('/"browseId":"(.*?)"/', $response, $channelId);

                if( !empty($channelId[1]) ) {

                    $source = $sst->url_get_contents( 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$channelId[1].'&key=' . $api_key->google_api_key );

                    $deJson = json_decode( $source, true );
                    
                    if( !empty( $deJson['items'][0]['snippet']['thumbnails'] ) ) {

                        $i = 0;

                        foreach ($deJson['items'][0]['snippet']['thumbnails'] as $key => $value) {

                            $token['url']      = $value['url'];
                            $token['filename'] = General::orderBy('id', 'DESC')->first()->prefix . $key;
                            $token['type']     = 'jpg';
                            $dlLink            = url('/') . '/dl.php?token=' . $sst->encode( json_encode($token) );

                            $data[$i]['download']   = $dlLink;
                            $data[$i]['preview']    = $value['url'];
                            $data[$i]['resolution'] = ucfirst( $key . ' (' . $value['width'] . 'x' . $value['height'] . ')' );

                            $i++;
                        }

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