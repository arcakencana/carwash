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
        ->groupBy('master_barang.nama')
        ->select(
            'master_barang.nama',

            DB::raw('SUM(transaksi_items.qty) as total_qty'),

            // total sebelum diskon
            DB::raw('SUM(transaksi_items.qty * transaksi_items.harga) as total_jual'),

            // total diskon
            DB::raw('SUM(transaksi_items.diskon) as total_diskon'),

            // setelah diskon
            DB::raw('SUM(transaksi_items.subtotal) as grand_total')
        )
        ->get();
    }


    public function headings(): array
    {
        return [
            'Nama Item',
            'Total Qty',
            'Total (Sebelum Diskon)',
            'Total Diskon',
            'Grand Total'
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
                $event->sheet->getStyle('C2:E1000')
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // Auto width
                foreach (['A','B','C','D','E'] as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
