<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanTransaksiExport implements WithMultipleSheets
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function sheets(): array
    {
        return [
            new \App\Exports\Sheets\RingkasanItemSheet($this->start, $this->end),
            new \App\Exports\Sheets\DetailTransaksiSheet($this->start, $this->end),
        ];
    }
}
