<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class DetailTransaksiSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
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
            'transaksi.kode_transaksi',
            'transaksi.tanggal',
            'transaksi.no_polisi',
            'master_barang.nama',
            'transaksi_items.qty',
            'transaksi_items.harga',
            'transaksi_items.diskon',
            'transaksi_items.subtotal'
        )
        ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'No Polisi',
            'Item',
            'Qty',
            'Harga',
            'Diskon',
            'Subtotal'
        ];
    }


    public function title(): string
    {
        return 'Detail Transaksi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getStyle('A1:G1')->getFont()->setBold(true);

                // Rupiah
                $event->sheet->getStyle('F2:H1000')
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
