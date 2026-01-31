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
}
