<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }
   
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
         return redirect()->intended('/dashboard'); 
           
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function register(Request $request)
    {
        $this->validate($request, [
            
            'username' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'user_type' =>  'required',
        ]
    ); 
        $data = new User();
        $data->username = $request->username;
        $data->email = $request->email;
        $data->user_type = $request->user_type;
        $data->password = Hash::make($request->password);
        $data->save();

        $message = 'Registration has been added in this system.';

        return redirect()->route('register')->with('message', $message);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
