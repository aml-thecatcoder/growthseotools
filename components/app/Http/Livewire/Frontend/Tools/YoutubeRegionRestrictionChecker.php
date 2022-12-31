<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use Illuminate\Support\Facades\Http;
use App\Classes\YoutubeRegionRestrictionCheckerClass;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class YoutubeRegionRestrictionChecker extends Component
{

    protected $listeners = ['onSetCountries'];
    public $link;
    public $data = [];

    public $allowed;
    public $blocked;

    public function render()
    {
        return view('livewire.frontend.tools.youtube-region-restriction-checker');
    }

    public function onSetCountries( $allowed, $blocked )
    {

        $this->allowed = $allowed;
        $this->blocked = $blocked;

    }

    public function onYoutubeRegionRestrictionChecker(){

        $this->validate([
            'link' => 'required'
        ]);

        $this->data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                $output = new YoutubeRegionRestrictionCheckerClass();

                $this->data = $output->get_data( $this->link );

                $this->dispatchBrowserEvent('data', $this->data);

            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->data) ) {

            $history             = new History;
            $history->tool_name  = 'YouTube Region Restriction Checker';
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
