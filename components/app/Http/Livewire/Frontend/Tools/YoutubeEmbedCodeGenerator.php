<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use Illuminate\Support\Facades\Http;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class YoutubeEmbedCodeGenerator extends Component
{

    public $link;
    public $size_width = '560';
    public $size_height = '315';
    public $start_min;
    public $start_sec;
    public $end_min;
    public $end_sec;
    public $loop_video;
    public $auto_play_video;
    public $hide_full_screen_button;
    public $hide_player_controls;
    public $hide_youtube_logo;
    public $no_cookie;
    public $responsive;

    public $data         = [];

    public function render()
    {
        return view('livewire.frontend.tools.youtube-embed-code-generator');
    }

    public function onYoutubeEmbedCodeGenerator(){

        $this->validate([
            'link' => 'required'
        ]);

        $this->data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                $check = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $this->link, $videoId);

                if ( $check ) {

                    $info = array(
                        'start'          => ( ( !empty($this->start_min) ? $this->start_min * 60 : 0 ) + ( !empty($this->start_sec) ? $this->start_sec : 0 ) ) ?: null,
                        'end'            => ( ( !empty($this->end_min) ? $this->end_min * 60 : 0 ) + ( !empty($this->end_sec) ? $this->end_sec : 0 ) ) ?: null,
                        'loop'           => ( $this->loop_video ) ?: $this->loop_video,
                        'autoplay'       => ( $this->auto_play_video ) ?: $this->auto_play_video,
                        'fs'             => ( $this->hide_full_screen_button ) ? 0 : null,
                        'controls'       => ( $this->hide_player_controls ) ? 0 : null,
                        'modestbranding' => ( $this->hide_youtube_logo ) ?: $this->hide_youtube_logo,
                    );

                    $query = http_build_query( array_filter($info, 'strlen') );

                    $embed_link = ( $this->no_cookie == true) ? 'https://www.youtube-nocookie.com/embed/' . $videoId[1] : 'https://www.youtube.com/embed/' . $videoId[1];

                    $embed_link .= ($query) ? '?' : '';

                    if ($this->responsive) {
                        
                        $this->data = '<div style="position:relative;height:0;overflow:hidden;padding-bottom:56.25%;border-style:none"><iframe style="position:absolute;top:0;left:0;width:100%;height:100%" src="'.$embed_link . $query.'"></iframe></div>';
                          
                    }
                    else $this->data = '<iframe width="'.$this->size_width.'" height="'.$this->size_height.'" src="'.$embed_link . $query.'"></iframe>';

                } else {

                    session()->flash('status', 'error');
                    session()->flash('message', __('Invalid Video URL!'));
                    return;
                }


            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->data) ) {

            $history             = new History;
            $history->tool_name  = 'YouTube Embed Code Generator';
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
