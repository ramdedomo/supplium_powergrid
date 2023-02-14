<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use App\Models\User;
use App\Models\UserType;
use WireUi\Traits\Actions;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;

class EditUser extends ModalComponent
{
    use Actions;

    public $user;
    public $userdetails;

    public $userfirstname;
    public $userlastname;
    public $email;
    public $userpassword;
    public $newpassword;

    public $department;
    public $department_;
    public $usertype;
    public $usertype_;

    public function mount($user){

        $this->user = $user;

     
        if(Auth::user()->user_type != 1){
            if(Auth::user()->user_type == 6){
                $this->usertype_ = UserType::whereIn('user_type', [6,4])->get();

                foreach(Department::all() as $d){
                    if($d->department == Auth::user()->department){
                        $this->department_ = [
                            'id' => $d->department,
                            'department' => $d->department_short
                        ];
                    }
                }
            }else{
                $this->usertype_ = UserType::where('user_type', '>', 1)->where('user_type', '<', 5)->get();

                foreach(Department::all() as $d){
                    if($d->department == Auth::user()->department){
                        $this->department_ = [
                            'id' => $d->department,
                            'department' => $d->department_short
                        ];
                    }
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

        $this->userdetails = User::where('id', $this->user)->first();

        $this->userfirstname = $this->userdetails->firstname;
        $this->userlastname = $this->userdetails->lastname;

        $this->usertype = $this->userdetails->user_type;
        $this->email = $this->userdetails->email;

        $this->department = $this->userdetails->department;
        
        // $this->userpassword = $this->userdetails->password;


    }


    protected function rules()
    {
        return [
            'userfirstname' => 'required',
            'userlastname' => 'required',
            'usertype' => 'required',
            'email' => 'required|string|email|max:255|unique:user,email,' . $this->user,
        ];
    }
    
    public function update(){
        
        //updating ced to someone
        if($this->department == 0 && $this->usertype != 5 && $this->usertype != 1){
            $this->reset('department');
        }
        
          //updating someone to ced
        if($this->department != 0 && $this->usertype == 5 || $this->usertype == 1){
            $this->department = 0;
        }

        $this->validate();

        if($this->usertype == 1){
            foreach ($this->department_ as $dep) {
                if($dep->department == $this->department && $dep->nonteaching == 1){
                    $this->validate([
                        'usertype' => 'required|in:4,6',
                        'department' => 'required'
                    ],[
                        'in' => 'Selected department is non-teaching, select usertype as "User/Instructor" or "Head"'
                    ]);
                }elseif($dep->department == $this->department && $dep->nonteaching == 0){
                    $this->validate([
                        'usertype' => 'required|in:2,3,4',
                        'department' => 'required'
                    ],[
                        'in' => 'Selected department is teaching, select usertype as "Dean", "Chairman" or "User/Instructor"'
                    ]);
                }else{
                   
                }
            }
        }else{
            $this->validate([
                'department' => 'required'
            ]);
        }
        

        if(Auth::user()->user_type != 1){
            $updated = User::where('id', $this->user)
            ->update([
                 'firstname' => $this->userfirstname,
                 'lastname' => $this->userlastname,
                 'email' => $this->email,
                 'user_type' => $this->usertype,
                 'department' => $this->department_['id']
            ]);
        }else{
            $updated = User::where('id', $this->user)
            ->update([
                 'firstname' => $this->userfirstname,
                 'lastname' => $this->userlastname,
                 'email' => $this->email,
                 'user_type' => $this->usertype,
                 'department' => $this->department
            ]);
        }




        if($updated){
            $this->dialog([
                'title'       => 'User Updated!',
                'description' => $this->userfirstname . ' ' . $this->userlastname . ' Information Updated!',
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

    public function delete(){
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Delete this User (' . $this->userfirstname . ' ' . $this->userlastname . ')?',
            'acceptLabel' => 'Yes, Confirm',
            'method'      => 'deleted',
            'params'      => 'User Deleted',
        ]);
    }

    public function deleted(){
        $this->closeModal();

        $deleted = User::where('id', $this->user)->delete();
 
        if($deleted){
            $this->dialog([
                'title'       => 'User Deleted!',
                'description' => $this->userfirstname . ' ' . $this->userlastname . " Deleted",
                'icon'        => 'warning'
            ]);
        }else{
            $this->dialog([
                'title'       => 'Something went Wrong',
                'description' => 'Please try again or later',
                'icon'        => 'warning'
            ]);
        }

        $this->emit('itemUpdated');
    }

    public function saved(){


        $validatedData = Validator::make(
            ['newpassword' => $this->newpassword],
            ['newpassword' => 'required|min:8'],
        )->validate();

        $update = User::where('id', $this->user)->update(
            ['password' => Hash::make($this->newpassword)
        ]);

        if($update){
            $this->dialog([
                'title'       => 'Password Updated!',
                'description' => 'New password updated: ' . $this->newpassword,
                'icon'        => 'warning'
            ]);
        }else{
            $this->dialog([
                'title'       => 'Something went Wrong',
                'description' => 'Please try again or later',
                'icon'        => 'warning'
            ]);
        }

    

        // $this->addError('key', 'message');

        

  
    }


    public function changepassword(){
        // $this->dialog()->confirm([
        //     'id' => 'changepassword',
        //     'icon' => 'question',
        //     'accept' =>  [
        //         'label' => 'Yes, save it',
        //         'method' => 'save',
        //     ],
            
        //     'reject' => [
        //         'label' => 'No, cancel',
        //     ],
        // ]);
        
    }

    public function render()
    {

        return view('livewire.edit-user');
    }
}
