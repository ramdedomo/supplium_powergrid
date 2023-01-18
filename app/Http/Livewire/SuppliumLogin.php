<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Hash;
use Session;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SuppliumLogin extends Component
{
    use Actions;

    public $password;
    public $email;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ];

    public function submit(Request $request)
    {

        // User::where('email', $this->email)->create(['password' => Hash::make(12345678)]);

        $credentials = $this->validate();
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('dashboard');
        }
        
        Session::flash('message', "User not found");
        return redirect()->back();

    }

    public function render()
    {
        return view('livewire.supplium-login')->layout('layouts.master-auth');
    }
}
