<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon; 
class DashboarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $user = Auth::user();
        $deposite = DB::table('accounts')
                        ->where('user_id',$user->id)
                        ->get();
        $withdraw = DB::table('withdraws')
                        ->where('user_id',$user->id)
                        ->get();
        $totalBalance = DB::table('accounts')
                        ->where('user_id',$user->id)
                        ->sum('balance');
        $totalWithdraw = DB::table('withdraws')
                        ->where('user_id', $user->id)
                        ->sum('balance');
                    
        $totalCharge = DB::table('withdraws')
                        ->where('user_id', $user->id)
                        ->sum('charge');
        $totalWithdrawAmount = $totalWithdraw + $totalCharge;
        $tot =   $totalBalance -  $totalWithdrawAmount ;                                
        return view('dashboard.dashboard',compact('deposite','withdraw','tot'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function store_deposit(Request $request)
    {
         $id = Auth::user()->id;
         $data = new Account();
         $data->user_id = $id;
         $data->balance = $request->amount;
         $data->status = 1;
         $data->save();

        $message = 'Deposite Your balance';

        return redirect()->route('home')->with('message', $message);
    }

    public function withdraw_show()
    {   
        $user = Auth::user();
        $totalBalance = DB::table('accounts')
                        ->where('user_id',$user->id)
                        ->sum('balance');
        $totalWithdraw = DB::table('withdraws')
                        ->where('user_id', $user->id)
                        ->sum('balance');
                    
        $totalCharge = DB::table('withdraws')
                        ->where('user_id', $user->id)
                        ->sum('charge');
        $totalWithdrawAmount = $totalWithdraw + $totalCharge;                              
        return view('dashboard.withdraw',compact('totalBalance','totalWithdrawAmount'));
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
            return redirect()->route('home')->withErrors($message);
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
        return redirect()->route('home')->with('message', 'Withdrawal successful.');
        }

    }
    public function store(Request $request)
    {
        //||  ($user->monthly_withdrawals <= 5000 && $user->total_withdrawals <= 50000)
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
