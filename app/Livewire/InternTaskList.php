<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class InternTaskList extends Component
{
    public function markDone($taskId)
    {
        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        $task->users()->updateExistingPivot($user->id, [
            'status' => 'done',
            'completed_at' => now(),
        ]);

        session()->flash('message', 'Task marked as done, waiting for approval.');
    }

    public function unmarkDone($taskId)
    {
        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        $task->users()->updateExistingPivot($user->id, [
            'status' => 'pending',
            'completed_at' => null,
        ]);

        session()->flash('message', 'Task unmarked as done.');
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.intern-task-list', [
            'tasks' => $user->tasks()->get()
        ]);
    }
}
