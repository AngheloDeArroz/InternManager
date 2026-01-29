<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Apply auth + admin middleware to all routes in this controller
        $this->middleware(['auth', 'admin']);
    }

    /** Admin dashboard */
    public function index()
    {
        return view('admin.dashboard');
    }

    /** Show all tasks */
    public function tasks()
    {
        $tasks = Task::with('users')->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    /** Show create task form */
    public function createTask(Request $request)
    {
        $preselectedInternId = $request->query('intern_id');
        return view('admin.tasks.create', compact('preselectedInternId'));
    }

    /** Save new task */
    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hours' => 'required|integer|min:1',
        ]);

        /** @var \App\Models\User $admin */
        $admin = Auth::user();

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'hours' => $request->hours,
            'created_by' => $admin->id,
        ]);

        if ($request->has('intern_ids')) {
            $task->users()->attach($request->intern_ids);
        }

        return redirect()->route('admin.tasks')->with('success', 'Task created and assigned successfully.');
    }

    /** Edit a task */
    public function editTask(Task $task)
    {
        return view('admin.tasks.edit', compact('task'));
    }

    /** Update task */
    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'hours' => 'required|integer|min:1',
        ]);

        $task->update($request->only('title', 'description', 'hours'));

        if ($request->has('intern_ids')) {
            $task->users()->sync($request->intern_ids);
        } else {
            $task->users()->detach();
        }

        return redirect()->route('admin.tasks')->with('success', 'Task and assignments updated successfully.');
    }

    /** Delete a task */
    public function deleteTask(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks')->with('success', 'Task deleted.');
    }

    /** Show interns list */
    public function interns()
    {
        $interns = User::where('role', 'intern')->get();
        return view('admin.interns.index', compact('interns'));
    }

    /** Show create intern form */
    public function createIntern()
    {
        return view('admin.interns.create');
    }

    /** Store new intern */
    public function storeIntern(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'required_hours' => 'required|integer|min:1',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'intern',
            'required_hours' => $request->required_hours,
        ]);

        return redirect()->route('admin.interns')->with('success', 'Intern created successfully.');
    }

    /** Edit intern */
    public function editIntern(User $user)
    {
        return view('admin.interns.edit', compact('user'));
    }

    /** Update intern */
    public function updateIntern(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'required_hours' => 'required|integer|min:1',
        ]);

        $user->update($request->only('name', 'email', 'required_hours'));

        return redirect()->route('admin.interns')->with('success', 'Intern updated successfully.');
    }

    /** Delete intern */
    public function deleteIntern(User $user)
    {
        $user->delete();
        return redirect()->route('admin.interns')->with('success', 'Intern deleted.');
    }
}
