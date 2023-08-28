<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Withdraw;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon; 
use DB;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

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
        return response()->json(['message' => 'User registered successfully']);
    }
   
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function deposit(Request $request)
    {  
        $id = Auth::user()->id;
         $data = new Account();
         $data->user_id = $id;
         $data->balance = $request->amount;
         $data->status = 1;
         $data->save();

         return response()->json([
            'message' => 'Successfully Deposit Amount',
        ],200);
    }

    public function withdraw(Request $request)
    {   
       
        $user = Auth::user();
        $withdrawalAmount = $request->input('amount');
        $accountType = $user->user_type;

        $totalBalance = DB::table('accounts')
                        ->where('user_id',$user->id)
                        ->sum('balance');
        $withdrawalFee = 0.0;
        
        if($totalBalance < $withdrawalAmount)
        {
             $message="Insufficient balance.";
             return response()->json([
                'message' => 'Insufficent Fund',
            ],304);
        }
        else {
            if ($accountType === 'individual') {
                $withdrawalFee = $withdrawalAmount * 0.0015;
                if (Carbon::now()->isFriday() || $withdrawalAmount <= 1000) {
                    $withdrawalFee = 0.0;
                }
            } elseif ($accountType === 'business') {
                $withdrawalFee = $withdrawalAmount * 0.0025;
                
                if ($user->total_withdrawals > 50000) {
                    $withdrawalFee = $withdrawalAmount * 0.0015;
                }
            }
         $data = new Withdraw();
         $data->user_id = $user->id;
         $data->balance = $withdrawalAmount;
         $data->charge = $withdrawalFee;
         $data->save();
         return response()->json([
            'message' => 'Successfully Withdraw Amount',
        ],200);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
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
