<?php

namespace Modules\JobRegisterManagement\App\Sheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KesenExport implements FromCollection, WithHeadings, WithCustomStartCell, WithStyles
{
    public $jobRegister;
    public function __construct($jobRegister){
        $this->jobRegister = $jobRegister;
    }
    public function collection()
    {
        return collect([
            ['', ''],
            ['Job no', '', '',$this->jobRegister->sr_no, ''],
            ['Old job no', '', '',$this->jobRegister->old_job_no, ''],
            ['Client name', '', '',$this->jobRegister->estimate?$this->jobRegister->estimate->client->name:$this->jobRegister->no_estimate->client->name, ''],
            ['Client Contact Person', '', '',$this->jobRegister->estimate?$this->jobRegister->estimate->client_person->name:$this->jobRegister->no_estimate->client_person->name, ''],
            ['Protocol Number', '', '',$this->jobRegister->protocol_no, ''],
            ['Document Name', '', '',$this->jobRegister->estimate_document_id, ''],
            ['', ''],
            ['Sr No', 'Dr names', 'Site no', 'Languages', 'No of sites']
        ]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            ['Kesen']
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A3:C3');
        $sheet->mergeCells('A4:C4');
        $sheet->mergeCells('A5:C5');
        $sheet->mergeCells('A6:C6');
        $sheet->mergeCells('A7:C7');
        $sheet->mergeCells('A8:C8');
        $sheet->mergeCells('D3:H3');
        $sheet->mergeCells('D4:H4');
        $sheet->mergeCells('D5:H5');
        $sheet->mergeCells('D6:H6');
        $sheet->mergeCells('D7:H7');
        $sheet->mergeCells('D8:H8');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D3')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('D4')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('D5')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('D6')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('D7')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('D8')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('D3')->getFont()->setBold(true);
        $sheet->getStyle('A10')->getFont()->setBold(true);
        $sheet->getStyle('B10')->getFont()->setBold(true);
        $sheet->getStyle('C10')->getFont()->setBold(true);
        $sheet->getStyle('D10')->getFont()->setBold(true);
        $sheet->getStyle('E10')->getFont()->setBold(true);
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
