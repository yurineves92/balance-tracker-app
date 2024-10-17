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
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $userId = auth()->id();
    
        $transactionsToday = Historic::where('user_id', $userId)
            ->whereDate('date', Carbon::today())
            ->count();
    
        $transactionsTodayValue = Historic::where('user_id', $userId)
            ->whereDate('date', Carbon::today())
            ->sum('amount');
    
        $balance = Balance::where('user_id', $userId)->first();
        $currentBalance = $balance ? $balance->amount : 0;
    
        $previousBalance = $currentBalance - $transactionsTodayValue;
    
        $totalIncoming = Historic::where('user_id', $userId)
            ->where('type', 'I')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
    
        $totalOutgoing = Historic::where('user_id', $userId)
            ->where('type', 'O')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
    
        $lastTransactions = Historic::where('user_id', $userId)
            ->with('user')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
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
