<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use Illuminate\Support\Facades\Http;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class YoutubeDescriptionGenerator extends Component
{

    protected $listeners = ['onSetInList', 'onClearInList'];
    public $about_the_video;
    public $about_the_video_status = true;

    public $timestamps;
    public $timestamps_status = true;

    public $about_the_channel;
    public $about_the_channel_status = true;

    public $recommended;
    public $recommended_status = true;

    public $about_our_products;
    public $about_our_products_status = true;

    public $our_website;
    public $our_website_status = true;

    public $contact;
    public $contact_status = true;

    public $data         = [];

    public function mount()
    {
        $this->about_the_video = 'Hi, thanks for watching our video about {your video}!
In this video, we\'ll walk you through:
- {Topic 1}
- {Topic 2}
- {Topic 3}';
        
        $this->timestamps = 'TIMESTAMPS
0:00 Intro
1:00 First Topic Covered
1:30 Second Topic Covered
2:30 Third Topic Covered';
        
        $this->about_the_channel = 'ABOUT OUR CHANNEL
Our channel is about {topic}. We cover lots of cool stuff such as {topic}, {topic} and {topic}
Check out our channel here:
https://www.youtube.com/channel
Don\'t forget to subscribe!';

        $this->recommended = 'CHECK OUT OUR OTHER VIDEOS
https://www.youtube.com/watch?v=video1
https://www.youtube.com/watch?v=video2
https://www.youtube.com/watch?v=video3';
        
        $this->about_our_products = 'We sell these excellent products. Check them out here:
https://www.website.com/product1
https://www.website.com/product2
https://www.website.com/product3';
        
        $this->our_website = 'FIND US AT
https://www.website.com/';

        $this->contact = 'GET IN TOUCH
Contact us at info@company.com

FOLLOW US ON SOCIAL
Get updates or reach out to Get updates on our Social Media Profiles!
Twitter: https://twitter.com/{profile}
Facebook: https://facebook.com/{profile}
Instagram: https://twitter.com/{profile}
Spotify: http://spotify.com/{profile}';
    }

    public function render()
    {
        return view('livewire.frontend.tools.youtube-description-generator');
    }

    public function onSetInList($value)
    {
        array_push($this->data, $value);
    }

    public function onClearInList()
    {
        $this->data = [];
    }

    public function onYoutubeDescriptionGenerator(){

        $this->data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                $this->data .= ( $this->about_the_video_status == true ) ? $this->about_the_video . PHP_EOL . PHP_EOL : '';

                $this->data .= ( $this->timestamps_status == true ) ? $this->timestamps . PHP_EOL . PHP_EOL : '';

                $this->data .= ( $this->about_the_channel_status == true ) ? $this->about_the_channel . PHP_EOL . PHP_EOL : '';

                $this->data .= ( $this->recommended_status == true ) ? $this->recommended . PHP_EOL . PHP_EOL : '';

                $this->data .= ( $this->about_our_products_status == true ) ? $this->about_our_products . PHP_EOL . PHP_EOL : '';

                $this->data .= ( $this->our_website_status == true ) ? $this->our_website . PHP_EOL . PHP_EOL : '';

                $this->data .= ( $this->contact_status == true ) ? $this->contact : '';

                $this->data = rtrim($this->data);

            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->data) ) {

            $history             = new History;
            $history->tool_name  = 'YouTube Description Generator';
            $history->client_ip  = request()->ip();

            require app_path('Classes/geoip2.phar');

            $reader = new Reader( app_path('Classes/GeoLite2-City.mmdb') );

            try {

                $record           = $reader->city( request()->ip() );

                $history->flag    = strtolower( $record->country->isoCode );
                
                $history->country = strip_tags( $record->country->name );

            } catch (AddressNotFoundException $e) {

            }

            $history->created_at = new DateTime();
            $history->save();
        }

    }
}
