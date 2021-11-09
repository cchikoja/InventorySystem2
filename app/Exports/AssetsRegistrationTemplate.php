<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AssetsRegistrationTemplate implements FromArray,WithHeadings, WithEvents, ShouldAutoSize
{
    protected $list;

    public function __construct($list)
    {
        $this->list = $list;
    }


    public function array(): array
    {
        // TODO: Implement array() method.
        return $this->list;
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:G1'; //All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->getColor()->setRGB('231f20');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('43AA8B');

                $sheet = $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
//                                'style'=>PHPExcel_Style_Border::BORDER_THIN,
                                'colour' => array('rgb' => 'FFFFFF')
                            )
                        )
                    )
                );
            },

        ];
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'Asset',
            'Serial Number',
            'Model',
            'Company',
            'Bought on',
            'Expires',
            'Description'
        ];
    }
}
