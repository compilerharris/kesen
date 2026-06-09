<?php

namespace Modules\EstimateManagement\App\Sheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EstimateExport implements FromCollection, WithHeadings, WithStyles
{
    public function __construct(private $rows) {}

    public function collection()
    {
        return $this->rows->map(fn($row) => [
            $row->sr,
            $row->date,
            $row->estimate_no,
            $row->amount,
            $row->metrix,
            $row->client_name,
            $row->contact_name,
            $row->contact_phone,
            $row->protocol_no,
            $row->created_by,
            $row->status,
        ]);
    }

    public function headings(): array
    {
        return [
            '#',
            'Date',
            'Estimate No',
            'Amount',
            'Metrix',
            'Client Name',
            'Contact Person',
            'Contact Phone',
            'Protocol No',
            'Created By',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
