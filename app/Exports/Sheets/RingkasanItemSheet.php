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
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class RingkasanItemSheet implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithTitle,
    WithEvents,
    WithCustomStartCell
{
    protected string $start;
    protected string $end;

    public function __construct(string $start, string $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * Ambil data ringkasan item
     */
    public function collection()
    {
        return DB::table('transaksi_items as ti')
        ->join('transaksi as t', 't.id', '=', 'ti.transaksi_id')
        ->join('master_barang as mb', 'mb.id', '=', 'ti.master_barang_id')
        ->whereBetween('t.tanggal', [$this->start, $this->end])
        ->where('t.status', 'sudah')
        ->groupBy('ti.master_barang_id', 'mb.nama')
        ->select(
            'mb.nama as nama_item',
            DB::raw('SUM(ti.qty) as total_qty'),
            // Total pendapatan (harga jual - modal)
            DB::raw('SUM(ti.qty * (ti.harga - mb.harga_modal)) as total_pendapatan'),
            // Total diskon
            DB::raw('SUM(ti.diskon) as total_diskon'),
            // Grand total
            DB::raw('SUM((ti.qty * (ti.harga - mb.harga_modal)) - ti.diskon) as grand_total')
        )
        ->orderBy('mb.nama')
        ->get();
    }

    /**
     * Header kolom
     */
    public function headings(): array
    {
        return [
            'Nama Item',
            'Total Qty',
            'Total Pendapatan',
            'Total Diskon',
            'Grand Total',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }


    /**
     * Style dasar
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris heading
            3 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    /**
     * Judul sheet
     */
    public function title(): string
    {
        return 'Ringkasan Item';
    }

    /**
     * Event setelah sheet dibuat
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // Judul laporan
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'LAPORAN PENJUALAN PER ITEM');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                    ],
                ]);

                // Format Rupiah
                $sheet->getStyle('C4:E1000')
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // Auto width kolom
                foreach (range('A', 'E') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
