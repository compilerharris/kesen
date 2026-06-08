<?php

namespace Modules\EstimateManagement\App\Sheet;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EstimateExport implements FromCollection, WithHeadings, WithStyles
{
    public function __construct(private $estimates) {}

    public function collection()
    {
        return $this->estimates->map(function ($row, $index) {
            $contactPerson = $row->client_person;
            $protocolNos = \Modules\JobRegisterManagement\App\Models\JobRegister::where('estimate_id', $row->id)
                ->pluck('protocol_no')
                ->implode(', ');

            return [
                $index + 1,
                Carbon::parse($row->created_at)->format('d-m-Y'),
                $row->estimate_no,
                calculateTotals($row->details, $row->discount ?? 0),
                $row->client->client_metric->code ?? '',
                $row->client->name ?? '',
                $contactPerson->name ?? '',
                $contactPerson->phone_no ?? '',
                $protocolNos,
                \App\Models\User::where('id', $row->created_by)->value('name') ?? '',
                $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected'),
            ];
        });
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
