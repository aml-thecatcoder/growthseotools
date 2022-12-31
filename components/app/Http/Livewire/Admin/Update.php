<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Migration;
use Illuminate\Support\Facades\Artisan;
use File;

class Update extends Component
{

    public function render()
    {
        return view('livewire.admin.update');
    }
    
    public function onUpdateDatabase()
    {
        try {

            Artisan::call('migrate', ['--force' => true]);

            //Artisan::call('view:clear');

            Artisan::call('config:clear');

            Artisan::call('cache:clear');

            File::delete('update.php');
            
            session()->flash('status', 'success');
            session()->flash('message', __( 'Data updated successfully!' ));
            return;

        } catch (\Exception $e) {

            session()->flash('status', 'error');
            session()->flash('message', __($e->getMessage()));
            return;
        }
    }

}
