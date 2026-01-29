<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class InternTaskList extends Component
{
    public $tasks;

    public function mount()
    {
        $user = Auth::user();
        $this->tasks = $user->tasks;
    }

    public function markDone($taskId)
    {
        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        $task->users()->updateExistingPivot($user->id, [
            'status' => 'done',
            'completed_at' => now(),
        ]);

        $this->mount();
        session()->flash('message', 'Task marked as done, waiting for approval.');
    }

    public function render()
    {
        return view('livewire.intern-task-list');
    }
}
