<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balance;
use App\Models\Historic;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
    
        $transactionsToday = Historic::whereDate('created_at', $today)->count();
        $transactionsTodayValue = Historic::whereDate('created_at', $today)->sum('amount');
    
        $balance = Balance::where('user_id', auth()->id())->first();
        $currentBalance = $balance->amount;
    
        $previousBalance = $currentBalance - $transactionsTodayValue;
    
        $totalIncoming = Historic::where('type', 'I')->sum('amount');
        $totalOutgoing = Historic::where('type', 'O')->sum('amount');
    
        $lastTransactions = Historic::with('user')
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        $lastTransactions->transform(function ($transaction) {
            $transaction->type = $transaction->type($transaction->type);
            $transaction->date = Carbon::parse($transaction->date)->format('d/m/Y');
            return $transaction;
        });
        
        return Inertia::render('Dashboard', [
            'transactionsToday' => $transactionsToday,
            'transactionsTodayValue' => $transactionsTodayValue,
            'currentBalance' => $currentBalance,
            'previousBalance' => $previousBalance,
            'totalIncoming' => $totalIncoming,
            'totalOutgoing' => $totalOutgoing,
            'lastTransactions' => $lastTransactions,
        ]);
    }
}
