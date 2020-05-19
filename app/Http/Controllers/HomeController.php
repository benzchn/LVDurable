<?php

namespace App\Http\Controllers;

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

        // auth()->user()->assignRole('student');

        if (auth()->user()->hasRole("admin")) {

            $user = User::all();
            return view('home-ad', compact('user'));
        } else if (auth()->user()->hasRole('personnal')) {

            $user = User::all();
            return view('home-personnal', compact('user'));
        } else {
            $user = User::all();
            return view('home', compact('user'));
        }
        // return view('home');
    }
}
