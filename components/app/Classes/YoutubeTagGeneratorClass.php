<?php 

namespace App\Classes;
use App\Classes\SSTClass;

class YoutubeTagGeneratorClass {

	public function get_data($query, $lang)
	{
        try {

            $sst = new SSTClass();
            
            $get_source = $sst->url_get_contents('http://suggestqueries.google.com/complete/search?callback=?&hl='.strtolower($lang).'&ds=yt&jsonp=suggestCallBack&client=youtube&q=' . urlencode($query));
                        
            $get_source = preg_match('/suggestCallBack\((.*)\)/', $get_source, $match);

            $deJson     = json_decode($match[1], true);

            $data = array();

            if ( $deJson[1] ) {

                foreach ($deJson[1] as $value) {

                    array_push($data, $value[0]);

                }
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