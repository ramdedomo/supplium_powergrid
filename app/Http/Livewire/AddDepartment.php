<?php

namespace App\Http\Livewire;
use LivewireUI\Modal\ModalComponent;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Department;

class AddDepartment extends ModalComponent
{
    public $department_full;
    public $department_short;
    public $nonteach;

    protected function rules()
    {
        return [
            'department_full' => 'required',
            'department_short' => 'required',
        ];
    }

    public function add(){
        $this->validate();

        Department::create([
            'department_description' => $this->department_full,
            'department_short' => $this->department_short,
            'nonteaching' => ($this->nonteach) ? 1 : 0
        ]);

        $this->closeModal();
        $this->emit('itemUpdated');
    }

    public function render()
    {
        return view('livewire.add-department');
    }
}
