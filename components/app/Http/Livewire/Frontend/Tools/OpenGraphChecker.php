<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use App\Classes\OpenGraphCheckerClass;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class OpenGraphChecker extends Component
{

    public $link;
    public $data = [];

    public function render()
    {
        return view('livewire.frontend.tools.open-graph-checker');
    }

    public function onOpenGraphChecker(){

        $this->data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                $output = new OpenGraphCheckerClass();

                $this->data = $output->get_data( $this->link );

            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->data) ) {

            $history             = new History;
            $history->tool_name  = 'Open Graph Checker';
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
