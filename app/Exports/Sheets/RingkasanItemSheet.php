<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    WithTitle,
    WithEvents
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class RingkasanItemSheet implements FromCollection, WithHeadings, WithStyles, WithTitle, WithEvents
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        return DB::table('transaksi_items')
            ->join('transaksi', 'transaksi.id', '=', 'transaksi_items.transaksi_id')
            ->join('master_barang', 'master_barang.id', '=', 'transaksi_items.master_barang_id')
            ->whereBetween('transaksi.tanggal', [$this->start, $this->end])
            ->where('transaksi.status', 'sudah')
            ->select(
                'master_barang.nama',
                DB::raw('SUM(qty) as total_qty'),
                DB::raw('SUM(subtotal) as total_jual')
            )
            ->groupBy('master_barang.nama')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Item',
            'Total Qty',
            'Total Penjualan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]]
        ];
    }

    public function title(): string
    {
        return 'Ringkasan Item';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Judul besar
                $event->sheet->mergeCells('A1:C1');
                $event->sheet->setCellValue('A1', 'LAPORAN PENJUALAN PER ITEM');
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ]
                ]);

                // Format Rupiah
                $event->sheet->getStyle('C2:C1000')
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

                // Auto width
                foreach (['A','B','C'] as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
