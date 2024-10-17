<?php

namespace App\Http\Controllers;

use App\Models\Historic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoricController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Historic::where('user_id', auth()->id());

        if ($request->filled('user_name') && $request->transaction_type === 'T') {
            $query->whereHas('transactionUser', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('transaction_type')) {
            $query->where('type', $request->transaction_type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $historic = $query->with('user:id,name', 'transactionUser:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $request->page);

        $historic->getCollection()->transform(function($transaction) {
            $transaction->type = $transaction->type($transaction->type);
            return $transaction;
        });

        return Inertia::render('Historic/Index', [
            'historic' => $historic,
            'filters' => $request->only(['start_date', 'end_date', 'transaction_type', 'user_name']),
        ]);
    }
}
