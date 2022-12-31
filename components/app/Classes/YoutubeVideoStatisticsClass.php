<?php 

namespace App\Classes;
use App\Classes\SSTClass;
use App\Models\Admin\ApiKeys;
use Google\Client;
use Google\Service\YouTube;

class YoutubeVideoStatisticsClass {

	public function get_data($link)
	{

        $api_key = ApiKeys::findOrFail(1);

        if ( !empty($api_key->google_api_key) ) {

            try {

                $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $link, $videoId);

                if ( $check ) {

                    $sst = new SSTClass();

                    $source = $sst->url_get_contents( 'https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics&id='.$videoId[1].'&key=' . $api_key->google_api_key );

                    $deJson = json_decode( $source, true );
                    
                    if( count($deJson['items'][0]['snippet']) != 0 ) {

                        $data                    = array();

                        $data['publishedAt']     = !empty( $deJson['items'][0]['snippet']['publishedAt'] ) ? $deJson['items'][0]['snippet']['publishedAt'] : 0;

                        $data['channelId']       = !empty( $deJson['items'][0]['snippet']['channelId'] ) ? $deJson['items'][0]['snippet']['channelId'] : 0;

                        $data['title']           = !empty( $deJson['items'][0]['snippet']['title'] ) ? $deJson['items'][0]['snippet']['title'] : 0;

                        $data['description']     = !empty( $deJson['items'][0]['snippet']['description'] ) ? $deJson['items'][0]['snippet']['description'] : 0;

                        $data['channelTitle']    = !empty( $deJson['items'][0]['snippet']['channelTitle'] ) ? $deJson['items'][0]['snippet']['channelTitle'] : 0;

                        $data['thumbnails']      = $deJson['items'][0]['snippet']['thumbnails'];

                        $data['tags']            = $deJson['items'][0]['snippet']['tags'];

                        $data['category']        = !empty( $deJson['items'][0]['snippet']['categoryId'] ) ? $this->CATEGORY_ID[$deJson['items'][0]['snippet']['categoryId']] : 0;

                        $data['defaultLanguage'] = !empty( $deJson['items'][0]['snippet']['defaultLanguage'] ) ? $deJson['items'][0]['snippet']['defaultLanguage'] : 0;

                        $data['viewCount'] = !empty( $deJson['items'][0]['statistics']['viewCount'] ) ? $deJson['items'][0]['statistics']['viewCount'] : 0;

                        $data['likeCount'] = !empty( $deJson['items'][0]['statistics']['likeCount'] ) ? $deJson['items'][0]['statistics']['likeCount'] : 0;

                        $data['commentCount'] = !empty( $deJson['items'][0]['statistics']['commentCount'] ) ? $deJson['items'][0]['statistics']['commentCount'] : 0;

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

    private $CATEGORY_ID = array(
        '1'  => 'Film & Animation',
        '2'  => 'Autos & Vehicles',
        '10' => 'Music',
        '15' => 'Pets & Animals',
        '17' => 'Sports',
        '18' => 'Short Movies',
        '19' => 'Travel & Events',
        '20' => 'Gaming',
        '21' => 'Videoblogging',
        '22' => 'People & Blogs',
        '23' => 'Comedy',
        '24' => 'Entertainment',
        '25' => 'News & Politics',
        '26' => 'Howto & Style',
        '27' => 'Education',
        '28' => 'Science & Technology',
        '29' => 'Nonprofits & Activism',
        '30' => 'Movies',
        '31' => 'Anime/Animation',
        '32' => 'Action/Adventure',
        '33' => 'Classics',
        '34' => 'Comedy',
        '35' => 'Documentary',
        '36' => 'Drama',
        '37' => 'Family',
        '38' => 'Foreign',
        '39' => 'Horror',
        '40' => 'Sci-Fi/Fantasy',
        '41' => 'Thriller',
        '42' => 'Shorts',
        '43' => 'Shows',
        '44' => 'Trailers'
    );
    //

}