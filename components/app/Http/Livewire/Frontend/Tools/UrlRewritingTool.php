<?php

namespace App\Http\Livewire\Frontend\Tools;

use Livewire\Component;
use App\Models\Admin\History;
use Illuminate\Support\Facades\Http;
use App\Classes\UrlRewritingToolClass;
use DateTime, File;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class UrlRewritingTool extends Component
{

    public $link;
    public $data = [];

    public function render()
    {
        return view('livewire.frontend.tools.url-rewriting-tool');
    }

    public function onUrlRewritingTool(){

        $this->validate([
            'link' => 'required|url'
        ]);

        $this->data = null;

        try {

            if (File::exists( app_path('Classes') ))
            {

                if ( !empty(parse_url(htmlspecialchars_decode( $this->link ))['query']) ) {

                    $rewrite = new UrlRewritingToolClass( $this->link );

                    if($rewrite->error)
                    {
                       $this->addError('error', __('The URL entered does not seem to be a dynamic URL!'));

                    } else {

                        $arr1 = $rewrite->getType1();
                        
                        $arr2 = $rewrite->getType2();
                        
                        $arr3 = $rewrite->getType3();
                        
                        $arr4  = $rewrite->getType4();

                        if(sizeof($arr1) > 0){

                            $this->data['host']  = $rewrite->host;
                            $this->data['type1'] = $rewrite->getOut($arr1);
                            $this->data['arr1']  = $arr1;
                            $this->data['type2'] = $rewrite->getOut($arr2);
                            $this->data['arr2']  = $arr2;
                            $this->data['type3'] = $rewrite->getOut($arr3);
                            $this->data['arr3']  = $arr3;
                            $this->data['type4'] = $rewrite->getOut($arr4);
                            $this->data['arr4']  = $arr4;
                        }

                    }                    

                } else $this->addError('error', __('The URL entered does not seem to be a dynamic URL!'));

            } else $this->addError('error', __('Missing addons detected. Please make sure you read the documentation!'));

        } catch (\Exception $e) {

            $this->addError('error', __($e->getMessage()));
        }

        //Save History
        if ( !empty($this->data) ) {

            $history             = new History;
            $history->tool_name  = 'URL Rewriting Tool';
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

    public function onSample()
    {
        $this->link = 'https://www.domain.com/test.php?categoryid=1&productid=10';
    }

    public function onReset()
    {
        $this->link = null;
    }
    //
}
