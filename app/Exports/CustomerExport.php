<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CustomerExport implements WithHeadings, FromQuery, WithStyles, ShouldAutoSize, WithProperties
{

    use Exportable;

    public function properties(): array
    {
        return [
            'creator'        => 'Fitra Fajar',
            'lastModifiedBy' => 'Fitra Fajar',
            'title'          => 'Data Pelanggan',
            'description'    => 'Data Pelanggan',
            'subject'        => 'Data Pelanggan',
            'keywords'       => 'pelanggan,rpl',
            'category'       => 'Pelanggan',
            'manager'        => 'Fitra Fajar',
        ];
    }

    public function query()
    {
        return Customer::select('name', 'phone', 'address')->orderBy('name');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Nama", "No Telepon", "Alamat"];
    }

    public function styles(Worksheet $sheet)
    {
        $count = Customer::select('name', 'phone', 'address')->count();
        // dd($count + 1);
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'size'  =>  12,
                'name'  =>  'Times New Roman'
            ],
        ];
        $sheet->getStyle('A2:C'.$count + 1)->applyFromArray($styleArray);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'bold'  =>  true,
                'size'  =>  13,
                'name'  =>  'Times New Roman'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
