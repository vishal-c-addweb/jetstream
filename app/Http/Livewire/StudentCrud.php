<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;

use App\Models\Student;

class StudentCrud extends Component
{
    use WithPagination;

    public  $name, $age, $address, $percentage, $school,  $student_id;
    public $isModalOpen = 0;

    public function render()
    {
        return view('livewire.student.studentcrud', [
            'students' => Student::paginate(10),
        ]);
    }

    /**
     * display data in yajra datatables.
     *
     * @param $request ajax request for fetching data.
     * 
     * @return redirect to department page.
     */
   

    private function resetCreateForm(){
        $this->name = '';
        $this->age = '';
        $this->address = '';
        $this->percentage = '';
        $this->school = '';
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'age' => 'required',
            'address' => 'required',
            'percentage' => 'required',
            'school' => 'required',
        ]);
    
        Student::updateOrCreate(['id' => $this->student_id], [
            'name' => $this->name,
            'age' => $this->age,
            'address' => $this->address,
            'percentage' => $this->percentage,
            'school' => $this->school,
        ]);

        session()->flash('message', $this->student_id? 'Student updated.' : 'Student created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->name;
        $this->age = $student->age;
        $this->address = $student->address;
        $this->percentage = $student->percentage;
        $this->school = $student->school;
    
        $this->openModalPopover();
    }
    
    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'Student deleted.');
    }
}
