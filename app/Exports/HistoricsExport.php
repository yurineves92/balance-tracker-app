<?php

namespace App\Exports;

use App\Models\Historic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class HistoricsExport implements FromQuery
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Historic::where('user_id', auth()->id());

        if ($this->request->filled('user_name') && $this->request->transaction_type === 'T') {
            $query->whereHas('transactionUser', function($q) {
                $q->where('name', 'like', '%' . $this->request->user_name . '%');
            });
        }

        if ($this->request->filled('transaction_type')) {
            $query->where('type', $this->request->transaction_type);
        }

        if ($this->request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $this->request->end_date);
        }

        return $query->orderBy('created_at', 'desc');
    }
}
