<?php
/**
 * Created by PhpStorm.
 * User: bdbposolutionsinc.
 * Date: 2020-09-03
 * Time: 10:14
 */

namespace App\Exports;



use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport implements ShouldAutoSize, WithHeadings, WithEvents {

    public function headings(): array {
        return [
            'Name',
            'Email',
            'Password',
        ];
    }

    public function registerEvents(): array {
        $worksheet_style = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'font' => [
                'color' => [
                    'rgb' => 'ffffff'
                ],
                'size' => 9,

            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4723D9',
                ]
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'fff'],
                ],
            ],
        ];


        return [
            AfterSheet::class => function(AfterSheet $event) use ($worksheet_style) {
                $cellRange = 'A1:C1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($worksheet_style);


                $header_columns = ['A' => 25, 'B' => 25, 'C' => 25];
                foreach ( $header_columns as $header_column => $value) {
                    $event->sheet->getDelegate()->getColumnDimension($header_column)->setAutoSize(false);
                    $event->sheet->getDelegate()->getColumnDimension($header_column)->setWidth($value);
                }
            }
        ];
    }

    public function getBlueHeader() {
        return [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'font' => [
                'color' => [
                    'rgb' => 'ffffff'
                ],
                'size' => 8
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0489BA'
                ]
            ]
        ];
    }

}

