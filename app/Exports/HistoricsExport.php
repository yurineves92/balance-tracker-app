<?php

namespace App\Exports;

use App\Models\Historic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class HistoricsExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting
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
            $query->whereDate('date', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('date', '<=', $this->request->end_date);
        }

        return $query->with('user:id,name', 'transactionUser:id,name')
                    ->orderBy('date', 'desc');
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->type($row->type),
            $this->formatCurrency($row->amount),
            $this->formatCurrency($row->total_before),
            $this->formatCurrency($row->total_after),
            $this->formatDateForExcel($row->date),
            $row->user->name ?? 'N/A',
            $this->getTransactionUser($row),
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo',
            'Quantia',
            'Antes',
            'Depois',
            'Data',
            'Usuário',
            'Transferência',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => '"R$" #,##0.00_-',
            'D' => '"R$" #,##0.00_-',
            'E' => '"R$" #,##0.00_-',
        ];
    }

    private function formatDateForExcel($date)
    {
        return Date::dateTimeToExcel(Carbon::parse($date));
    }

    private function formatCurrency($value)
    {
        return number_format($value, 2, ',', '.');
    }

    private function getTransactionUser($row)
    {
        return $row->user_id_transaction ? $row->transactionUser->name : 'N/A';
    }
}
