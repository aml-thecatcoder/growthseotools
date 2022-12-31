<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use Brotzka\DotenvEditor\DotenvEditor;

class Smtp extends Component
{
	public $host;
	public $port;
	public $username;
	public $password;
	public $encryption = 'tls';
	public $mail_from_address;
	
	public function mount()
	{
		$env                     = new DotenvEditor();
		$this->mail_from_address = $env->getValue("MAIL_FROM_ADDRESS");
		$this->host              = $env->getValue("MAIL_HOST");
		$this->port              = $env->getValue("MAIL_PORT");
		$this->username          = $env->getValue("MAIL_USERNAME");
		$this->password          = $env->getValue("MAIL_PASSWORD");
		$this->encryption        = $env->getValue("MAIL_ENCRYPTION");
	}

    public function render()
    {
        return view('livewire.admin.settings.smtp');
    }

    public function onUpdateSMTP(){

    	try {

	        $env = new DotenvEditor();

	        $env->changeEnv([
				'MAIL_HOST'         => $this->host,
				'MAIL_PORT'         => $this->port,
				'MAIL_USERNAME'     => $this->username,
				'MAIL_PASSWORD'     => "'$this->password'",
				'MAIL_ENCRYPTION'   => $this->encryption,
				'MAIL_FROM_ADDRESS' => $this->mail_from_address
	        ]);

	        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('Data updated successfully!')]);
        
    	} catch (\Exception $e) {
    		$this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => __($e->getMessage()) ]);
    	}

    }
}
