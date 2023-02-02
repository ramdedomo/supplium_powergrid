<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Department;
use App\Models\User;

class EditDepartment extends ModalComponent
{

    use Actions;
    public $department_full;
    public $department_short;
    public $nonteach;
    public $department;
 
    public function mount($department){
      $this->department = Department::where('department', $department)->first();

      $this->department_full =  $this->department->department_description;
      $this->department_short =  $this->department->department_short;
      $this->nonteach = ($this->department->nonteaching == 1) ? true : false;
    }

    protected function rules()
    {
        return [
            'department_full' => 'required',
            'department_short' => 'required',
        ];
    }

    public function deletedall(){
        User::where('department', $this->department->department)->delete();
        Department::find($this->department->department)->delete();
        $this->closeModal();
        $this->emit('itemUpdated');
    }

    public function deleted(){
        Department::find($this->department->department)->delete();
        $this->closeModal();
        $this->emit('itemUpdated');
    }

    public function delete(){
        $constraint = User::where('department', $this->department->department)->exists();
        if($constraint){
            $this->dialog()->confirm([
                'title'       => 'Some users are linked into this department. Are you sure?',
                'description' => 'Warning: This department and all linked users will be deleted.',
                'acceptLabel' => 'Yes, Confirm',
                'method'      => 'deletedall',
                'params'      => 'Item Deleted',
            ]);
        }else{
            $this->dialog()->confirm([
                'title'       => 'Are you sure?',
                'description' => 'Delete this Department (' . $this->department->department_description . ')?',
                'acceptLabel' => 'Yes, Confirm',
                'method'      => 'deleted',
                'params'      => 'Item Deleted',
            ]);
        }

 
    }

    public function update(){
        $this->validate();

        Department::find($this->department->department)
        ->update([
            'department_description' => $this->department_full,
            'department_short' => $this->department_short,
            'nonteaching' => ($this->nonteach) ? 1 : 0
        ]);

        $this->closeModal();
        $this->emit('itemUpdated');
    }

    public function render()
    {
        $hasuser = User::where('department', $this->department->department)->exists();
        return view('livewire.edit-department', ['hasuser' => $hasuser]);
    }
}
