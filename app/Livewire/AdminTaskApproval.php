<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminTaskApproval extends Component
{
    public function approve($taskId, $userId)
    {
        \Illuminate\Support\Facades\DB::table('task_user')
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'updated_at' => now(),
            ]);

        session()->flash('message', 'Task approved!');
    }

    public function unapprove($taskId, $userId)
    {
        \Illuminate\Support\Facades\DB::table('task_user')
            ->where('task_id', $taskId)
            ->where('user_id', $userId)
            ->update([
                'status' => 'done',
                'approved_by' => null,
                'approved_at' => null,
                'updated_at' => now(),
            ]);

        session()->flash('message', 'Task approval retracted.');
    }

    public function render()
    {
        return view('livewire.admin-task-approval', [
            'tasks' => Task::with('users')->get()
        ]);
    }
}
