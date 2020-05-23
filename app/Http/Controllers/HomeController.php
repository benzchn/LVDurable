<?php

namespace App\Http\Controllers;

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
        // if (auth()->user()->user_status == 1) {
        if (auth()->user()->role == 'admin') {
            return view('admin.home-admin');
        } elseif (auth()->user()->role == 'personal') {

            return view('user.home-personal');
        } elseif (auth()->user()->role == 'student') {


            return view('user.home-student');
        } else {
            return error_reporting();
        }
        // }
        // elseif (auth()->user()->user_status == 0) {
        //     return back()->with('message', 'กรุณารอ การยืนยันการสมัคร จากแอดมิน!!');
        // }
        // else {
        //     return redirect()->back()->withErrors('อีเมล หรือ รหัสผ่าน ไม่ถูกต้อง!! กรุณากรอกข้อมูลให้ถูกต้อง');
        // }
    }
}
