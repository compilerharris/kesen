<?php

namespace Modules\JobCardManagement\App\Sheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobCardExcelExport implements FromCollection, WithHeadings, WithCustomStartCell
{
    public $jobCards;
    public function __construct($jobCards){
        $this->jobCards = $jobCards;
    }
    public function collection()
    {
        return $this->jobCards;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date', 'Job No.', 'Project Manager', 'Client', 'Client Contact',
            'Estimate No.', 'Document Name', 'Protocol No.', 'Version No.',
            'Version Date', 'Languages', 'Delivery Date', 'Status'
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
    // public function styles(Worksheet $sheet)
    // {
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A3:C3');
    //     $sheet->mergeCells('A4:C4');
    //     $sheet->mergeCells('A5:C5');
    //     $sheet->mergeCells('A6:C6');
    //     $sheet->mergeCells('A7:C7');
    //     $sheet->mergeCells('A8:C8');
    //     $sheet->mergeCells('D3:H3');
    //     $sheet->mergeCells('D4:H4');
    //     $sheet->mergeCells('D5:H5');
    //     $sheet->mergeCells('D6:H6');
    //     $sheet->mergeCells('D7:H7');
    //     $sheet->mergeCells('D8:H8');
    //     $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //     $sheet->getStyle('D3')->getAlignment()->setHorizontal('left');
    //     $sheet->getStyle('D4')->getAlignment()->setHorizontal('left');
    //     $sheet->getStyle('D5')->getAlignment()->setHorizontal('left');
    //     $sheet->getStyle('D6')->getAlignment()->setHorizontal('left');
    //     $sheet->getStyle('D7')->getAlignment()->setHorizontal('left');
    //     $sheet->getStyle('D8')->getAlignment()->setHorizontal('left');
    //     $sheet->getStyle('D3')->getFont()->setBold(true);
    //     $sheet->getStyle('A10')->getFont()->setBold(true);
    //     $sheet->getStyle('B10')->getFont()->setBold(true);
    //     $sheet->getStyle('C10')->getFont()->setBold(true);
    //     $sheet->getStyle('D10')->getFont()->setBold(true);
    //     $sheet->getStyle('E10')->getFont()->setBold(true);
    //     return [
    //         1 => ['font' => ['bold' => true]],
    //     ];
    // }

    public function map($jobCard): array
    {
        return [
            $jobCard->created_at ? $jobCard->created_at->format('j M Y') : '',
            $jobCard->sr_no,
            $jobCard->handle_by->name,
            $jobCard->estimate->client->name,
            $jobCard->estimate->client_person->name,
            $jobCard->estimate->estimate_no,
            $jobCard->estimate_document_id,
            $jobCard->protocol_no,
            $jobCard->version_no,
            $jobCard->version_date,
            $jobCard->languages,
            $jobCard->date ? $jobCard->date->format('j M Y') : '',
            $jobCard->status == 0 ? 'In Progress' : ($jobCard->status == 1 ? 'Completed' : 'Canceled')
        ];
    }
}
