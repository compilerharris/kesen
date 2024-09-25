<?php

namespace Modules\JobCardManagement\App\Sheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

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
            '#',
            'Date',
            'Job No',
            'Project Manager',
            'Client Name',
            'Contact Person',
            'Estimate No.',
            'Languages',
            'Old Job No.',
            'Protocol No.',
            'Job Type',
            'Job Description',
            'Remark',
            'Billing Status',
            'Status'
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A1';
    }

    public function map($jobCard): array
    {
        return [
            $jobCard->sr,
            $jobCard->date,
            $jobCard->sr_no,
            $jobCard->handledBy,
            $jobCard->clientName,
            $jobCard->clientContact,
            $jobCard->estimateNo,
            $jobCard->languages,
            $jobCard->oldJobNo,
            $jobCard->protocolNo,
            $jobCard->jobType,
            $jobCard->docName,
            $jobCard->remark,
            $jobCard->billingStatus,
            $jobCard->status
        ];
        // $jobCard->created_at ? $jobCard->created_at->format('j M Y') : '',
        // $jobCard->sr_no,
        // $jobCard->handle_by->name,
        // $jobCard->estimate->client->name,
        // $jobCard->estimate->client_person->name,
        // $jobCard->estimate->estimate_no,
        // $jobCard->estimate_document_id,
        // $jobCard->protocol_no,
        // $jobCard->version_no,
        // $jobCard->version_date,
        // $jobCard->languages,
        // $jobCard->date ? $jobCard->date->format('j M Y') : '',
        // $jobCard->status == 0 ? 'In Progress' : ($jobCard->status == 1 ? 'Completed' : 'Canceled')
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = count($this->jobCards) + 1; // +1 to account for the headings row

                for ($row = 2; $row <= $rowCount + 1; $row++) {
                    $statusCell = $sheet->getCellByColumnAndRow(15, $row); // Assuming "Status" is in the 12th column
                    $statusValue = $statusCell->getValue();

                    // Debugging: Output the status value (optional)
                    echo "Row {$row} Status: {$statusValue}\n";

                    if ($statusValue == 'Canceled') {
                        $sheet->getStyle($statusCell->getCoordinate())->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFF0000'], // Red color
                            ],
                        ]);
                    } elseif ($statusValue == 'Completed') {
                        $sheet->getStyle($statusCell->getCoordinate())->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FF00FF00'], // Green color
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
