<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InternController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'intern']);
    }

    /** Intern dashboard */
    public function dashboard()
    {
        return view('intern.dashboard'); // Livewire will handle tasks & hours
    }

    /** Mark a task as done */
    public function markDone(Task $task)
    {
        /** @var User $user */
        $user = Auth::user(); // typehint so IDE knows $user is a User

        $task->users()->updateExistingPivot($user->id, [
            'status' => 'done',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Task marked as done, awaiting admin approval.');
    }
}
