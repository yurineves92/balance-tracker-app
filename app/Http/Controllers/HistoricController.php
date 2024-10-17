<?php

namespace App\Http\Controllers;

use App\Exports\HistoricsExport;
use App\Models\Historic;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Export the historics to PDF.
     */
    public function exportPdf(Request $request)
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

        $historics = $query->with('user:id,name', 'transactionUser:id,name')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('historics.pdf', compact('historics'));
        return $pdf->download('historics.pdf');
    }

    public function exportXls(Request $request)
    {
        return Excel::download(new HistoricsExport($request), 'historics.xlsx');
    }   
}
