<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        // $this->middleware('guest:admin');
        // $this->middleware('guest:personnel');
        // $this->middleware('guest:student');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => ['required', 'string', 'max:11'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email',  'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:10'],
            'degree' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'col_year' => ['required', 'integer'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'user_id' => $data['user_id'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'degree' => $data['degree'],
            'department' => $data['department'],
            'col_year' => $data['col_year'],

        ]);
    }


    // protected function createPersonnel(array $data)
    // {
    //     return User::create([
    //         'user_id' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'phone' => $data['phone'],
    //         'degree' => '',
    //         'department' => '',
    //         'col_year' => '',
    //         'role' => $data['role'],

    //     ]);
    // }

    // protected function createPersonnel(Request $request)
    // {
    //     $this->validator($request->all())->validate();
    //     User::create([
    //         'user_id' => $request->email,
    //         'email' => $request->email,
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'password' => Hash::make($request->password),
    //         // 'degree' => null,
    //         // 'department' => null,
    //         // 'col_year' => null,
    //         'role' => $request->role,


    //     ]);
    //     return redirect()->intended('/home');
    // }
}
