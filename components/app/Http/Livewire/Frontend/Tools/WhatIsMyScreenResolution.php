<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class WhatIsMyScreenResolution extends Component
{
    public $data = [];
    protected $listeners = ['onWhatIsMyScreenResolution'];

    public function render()
    {
        return view('livewire.frontend.tools.what-is-my-screen-resolution');
    }

    public function onSetScreenResolution(){
        $this->dispatchBrowserEvent('onSetScreenResolution');
    }

    public function onWhatIsMyScreenResolution($width, $height, $dpr, $color, $viewport_width, $viewport_height){

        $this->data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                $this->data['width']  = $width;
                $this->data['height'] = $height;
                $this->data['dpr'] = $dpr;
                $this->data['color'] = $color;
                $this->data['viewport_width'] = $viewport_width;
                $this->data['viewport_height'] = $viewport_height;

            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));
            
        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->data) ) {

            $history             = new History;
            $history->tool_name  = 'What Is My Screen Resolution';
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
    //
}
