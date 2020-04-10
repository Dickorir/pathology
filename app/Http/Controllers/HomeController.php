<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Pathology;
use App\Patient;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $patients = Patient::count();
        $pathologies = Pathology::count();
        return view('home', compact('pathologies','patients', 'users'));
    }

    public function logActivity()
    {
        $logs = LogActivity::logActivityLists();
        return view('logActivity',compact('logs'));
    }
}
