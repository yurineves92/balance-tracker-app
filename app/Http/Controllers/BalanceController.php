<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Historic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $balance = Balance::where(['user_id' => auth()->id()])->get();

        return Inertia::render('Balance/Index', [
            'balance' => $balance,
            'flash' => session('message')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:I,O,T',
            'amount' => 'required|numeric|min:0.01',
            'email' => 'nullable|email|required_if:type,T',
        ]);

        $balance = Balance::firstOrCreate(
            ['user_id' => auth()->id()],
            ['amount' => 0]
        );
    
        $totalBefore = $balance->amount;

        switch ($request->type) {
            case 'I':
                $balance->amount += $request->amount;
                break;

            case 'O':
                if ($balance->amount < $request->amount) {
                    return redirect()->back()->withErrors(['message' => 'Saldo insuficiente.']);
                }
                $balance->amount -= $request->amount;
                break;

            case 'T':
                if ($balance->amount < $request->amount) {
                    return redirect()->back()->withErrors(['message' => 'Saldo insuficiente.']);
                }
                $balance->amount -= $request->amount;

                $recipient = Balance::whereHas('user', function ($query) use ($request) {
                    $query->where('email', $request->email);
                })->firstOrFail();

                $recipient->amount += $request->amount;
                $recipient->save();
                break;
        }
        
        $balance->save();

        Historic::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'amount' => $request->amount,
            'total_before' => $totalBefore,
            'total_after' => $balance->amount,
            'user_id_transaction' => $request->type === 'T' ? $recipient->user_id : null,
            'date' => now(),
        ]);

        return redirect()->back()->with('message', 'Transação realizada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Balance $balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Balance $balance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Balance $balance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Balance $balance)
    {
        //
    }
}
