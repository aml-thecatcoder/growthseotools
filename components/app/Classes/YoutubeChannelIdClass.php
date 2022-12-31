<?php 

namespace App\Classes;
use App\Classes\SSTClass;

class YoutubeChannelIdClass {

	public function get_data($link)
	{

        try {

            $sst = new SSTClass();

            $source = $sst->url_get_contents($link);

            preg_match('/"browseId":"(.*?)"/', $source, $channelId);

            if( !empty($channelId[1]) ) {

                $data = $channelId[1];

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
	}
    //

}