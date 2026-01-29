<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Task;

class AdminDashboard extends Component
{
    public $interns;
    public $tasks;

    public function mount()
    {
        $this->interns = User::where('role', 'intern')->get();
        $this->tasks = Task::all();
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
