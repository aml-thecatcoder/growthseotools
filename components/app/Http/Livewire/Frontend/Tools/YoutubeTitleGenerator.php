<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use Illuminate\Support\Facades\Http;
use App\Classes\YoutubeTitleGeneratorClass;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class YoutubeTitleGenerator extends Component
{
    protected $listeners = ['onSetInList', 'onClearInList'];
    public $query;
    public $country = 'US';
    public $data         = [];
    public $temp_data    = [];

    public function render()
    {
        return view('livewire.frontend.tools.youtube-title-generator');
    }

    public function onSetInList($value)
    {
        array_push($this->data, $value);
    }

    public function onClearInList()
    {
        $this->data = [];
    }

    public function onYoutubeTitleGenerator(){

        $this->validate([
            'query'   => 'required',
            'country' => 'required'
        ]);

        $this->temp_data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                $output = new YoutubeTitleGeneratorClass();

                $this->temp_data = $output->get_data( $this->query, $this->country );

            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->temp_data) ) {

            $history             = new History;
            $history->tool_name  = 'YouTube Title Generator';
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
