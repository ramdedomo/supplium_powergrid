<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Models\Department;
use App\Models\UserType;
use WireUi\Traits\Actions;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AddUser extends ModalComponent
{
    use Actions;

    public $email;
    public $password;
    public $userfirstname;
    public $userlastname;
    public $usertype;
    public $usertype_;
    public $department_;
    public $department;

    protected function rules()
    {
        return [
            'userfirstname' => 'required',
            'userlastname' => 'required',
            'usertype' => 'required',
            'password' => 'required:min:8',
            'email' => 'required|string|email|max:255|unique:user,email'
        ];
    }

    public function mount(){

    }


    public function add(){
    
        $this->validate();

        foreach ($this->department_ as $dep) {
            if($dep->department == $this->department && $dep->nonteaching == 1){
                $this->validate([
                    'usertype' => 'required|in:4'
                ],[
                    'in' => 'Selected department is non-teaching, select usertype as "User"'
                ]);
            }
        }

        if(Auth::user()->user_type != 1){
            $created = User::create([
                'user_type' => $this->usertype,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'firstname' => $this->userfirstname,
                'lastname' => $this->userlastname,
                'department' => $this->department_['id']
            ]);
        }else{
            //if ced or supply
            if($this->usertype == 5){
                $created = User::create([
                    'user_type' => $this->usertype,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'firstname' => $this->userfirstname,
                    'lastname' => $this->userlastname,
                    'department' => 0
                ]);
            }else{
                $created = User::create([
                    'user_type' => $this->usertype,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'firstname' => $this->userfirstname,
                    'lastname' => $this->userlastname,
                    'department' => $this->department
                ]);
            }

        }



        if($created){
            $this->dialog([
                'title'       => 'User Added!',
                'description' => $this->userfirstname . ' ' . $this->userlastname . ' Added!',
                'icon'        => 'warning'
            ]);
        }else{
            $this->dialog([
                'title'       => 'Something went Wrong',
                'description' => 'Please try again or later',
                'icon'        => 'warning'
            ]);
        }

        $this->closeModal();
        $this->emit('itemUpdated');

    }

    public function render()
    {

        if(Auth::user()->user_type != 1){
            $this->usertype_ = UserType::where('user_type', '>', 1)->where('user_type', '<', 5)->get();

            foreach(Department::all() as $d){
                if($d->department == Auth::user()->department){
                    $this->department_ = [
                        'id' => $d->department,
                        'department' => $d->department_short
                    ];
                }
            }
        }else{
            $this->usertype_ = UserType::where('user_type', '>', 1)->get();
            $this->department_ = Department::where('department', '!=', 0)->get();
  
            foreach ($this->department_ as $dep) {
                if($dep->nonteaching == 1){
                    $dep->nonteaching = "Non-Teaching";
                }else{
                    $dep->nonteaching = "Teaching";
                }
            }

        }

        return view('livewire.add-user');
    }
}
