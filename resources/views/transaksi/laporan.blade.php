<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* Menggunakan font yang mendukung karakter non-latin untuk dompdf */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        /* --- CONTENT STYLES (Dihilangkan Float) --- */
        .content {
            margin-top: 5px;
            /* Hapus overflow: hidden, tidak diperlukan lagi */
        }

        /* --- data-box CSS DIHAPUS, karena kita menggunakan border pada TD luar */
        
        /* --- TABLE BOX STYLES --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; 
            /* Catatan: data-table ini adalah tabel yang ada di DALAM TD */
        }

        /* Aturan border di TH/TD hanya berlaku untuk HEADER DATA */
        .data-table.header-table th, .data-table.header-table td {
            border: 1px solid #000;
            vertical-align: top;
        }

        .data-table th {
            text-align: center;
            background-color: #f0f0f0;
        }

        /* Lebar spesifik untuk kolom QR dan TTD (HARUS KONSISTEN) */
        .qr-col {
            width: 25%; /* 25% dari 50% lebar kolom (12.5% dari total halaman) */
            text-align: center;
        }

        .ttd-col {
            width: 15%; /* 15% dari 50% lebar kolom (7.5% dari total halaman) */
            text-align: center;
            font-weight: bold;
        }

        /* Nama PBP akan otomatis mendapatkan sisa lebar: 100% - 25% - 15% = 60% */

        .data-table img.qr-code {
            height: 40px;
            width: 40px;
        }

        /* --- FINAL FIX CLEARFLOAT FOR FOOTER --- */
        .footer-container {
            width: 100%;
            overflow: hidden; /* Menggantikan div footer lama */
            margin-top: 10px;
        }
        .footer-container > div {
            float: left;
        }

        /* ... (CSS Footer lainnya, tidak diubah) ... */

        .page-break {
            page-break-after: always;
        }
    </style>
    <title>Laporan</title>
</head>
<body>
    <h4></h4>
    <div class="content">

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;">
                    <table class="data-table header-table"> 
                        <thead>
                            <tr>
                                <th style="width: 50%;">Nama</th>
                                <th class="qr-col">QR Code</th>
                                <th class="ttd-col">TTD***</th>
                            </tr>
                        </thead>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table class="data-table header-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Nama</th>
                                <th class="qr-col">QR Code</th>
                                <th class="ttd-col">TTD***</th>
                            </tr>
                        </thead>
                    </table>
                </td>
            </tr>

            @for ($i = 0; $i < count($laporan); $i += 2)
            <tr>
                <td style="width: 50%; padding: 3px; border: 1px solid #000; box-sizing: border-box;">
                    @php
                    $data_kiri = $laporan[$i];
                    $index_kiri = $i + 1;
                    @endphp
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td style="width: 60%;">
                                    <strong>{{ strtoupper($data_kiri['nama'] ?? $data_kiri->nama) }}</strong><br> 
                                    {{ $data_kiri['alamat'] ?? $data_kiri->alamat }}<br>
                                    {{ $data_kiri['kk'] ?? $data_kiri->kk }} - {{ $data_kiri['ktp'] ?? $data_kiri->ktp }}<br>
                                    Kelurahan : {{ $data_kiri['nama_kelurahan'] ?? $data_kiri->nama_kelurahan }}<br>
                                    Antrian : {{ $data_kiri['antrian'] ?? $data_kiri->antrian }}
                                </td>
                                <td class="qr-col">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('verifikasi.show', encrypt($data_kiri['pendaftaran_id'] ?? $data_kiri->pendaftaran_id))) }}" class="qr-code" alt="QR Code">
                                </td>
                                <td class="ttd-col">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                <td style="width: 50%; padding: 3px; border: 1px solid #000; box-sizing: border-box;">
                    @if (isset($laporan[$i + 1]))
                    @php
                    $data_kanan = $laporan[$i + 1];
                    $index_kanan = $i + 2;
                    @endphp
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <td style="width: 60%;">
                                    <strong>{{ strtoupper($data_kanan['nama'] ?? $data_kanan->nama) }}</strong><br> 
                                    {{ $data_kanan['alamat'] ?? $data_kanan->alamat }}<br>
                                    {{ $data_kanan['kk'] ?? $data_kanan->kk }} - {{ $data_kanan['ktp'] ?? $data_kanan->ktp }}<br>
                                    Kelurahan : {{ $data_kanan['nama_kelurahan'] ?? $data_kanan->nama_kelurahan }}<br>
                                    Antrian : {{ $data_kanan['antrian'] ?? $data_kanan->antrian }}
                                </td>
                                <td class="qr-col">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode(route('verifikasi.show', encrypt($data_kanan['pendaftaran_id'] ?? $data_kanan->pendaftaran_id))) }}" class="qr-code" alt="QR Code">
                                </td>
                                <td class="ttd-col">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </td>
            </tr>
            {{-- Logika Page Break --}}
            @if (($i + 2) % 14 == 0 && $i + 2 < count($laporan))
            <tr><td colspan="2" class="page-break"></td></tr>
            @endif
            @endfor
        </table>

    </div>

</body>
</html>