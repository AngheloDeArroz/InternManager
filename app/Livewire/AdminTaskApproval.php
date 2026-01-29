<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminTaskApproval extends Component
{
    public $tasks; // tasks with pivot assignments

    public function mount()
    {
        $this->tasks = Task::with('users')->get();
    }

    public function approve($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $admin = Auth::user();

        $task->users()->updateExistingPivot($userId, [
            'status' => 'approved',
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        $this->mount();
        session()->flash('message', 'Task approved!');
    }

    public function render()
    {
        return view('livewire.admin-task-approval');
    }
}
