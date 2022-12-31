<?php

namespace App\Http\Livewire\Frontend\AuthPages;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\User;
use App\Models\Admin\AuthPages;

class Register extends Component
{

    public $email;
    public $password;
    public $fullname;

    public function render()
    {
        return view('livewire.frontend.auth-pages.register');
    }

    public function onRegister()
    {
        $this->validate([
            'fullname' => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required'
        ]);

        try {

            $user = User::create([
                'fullname' => $this->fullname,
                'email'    => $this->email,
                'password' => Hash::make( $this->password )
            ]);

            if ( AuthPages::where('name', 'Verify Email')->first()->status == true) {

                $user->sendEmailVerificationNotification();

                session()->flash('status', 'success');
                session()->flash('message', __('Thanks for signing up! Before getting started, please check your email for account verification link.'));

            } else {

                session()->flash('status', 'success');
                session()->flash('message', __('Thanks for signing up. You can now login!'));
            }

        } catch (Exception $e) {
            $this->addError('401', __($e->getMessage()));
        }

    }

}
