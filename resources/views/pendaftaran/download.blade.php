<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendaftaran {{ $pendaftaran->nama }}</title>
    <style>
        /* Mengatur font agar kompatibel dengan DOMPDF */
        @font-face {
            font-family: 'Arial';
            src: url('{{ storage_path("fonts/Arial.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt; /* Ukuran font standar */
        }

        .container {
            padding: 20px;
        }

        /* Header dan Judul */
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 11pt;
            font-weight: bold;
        }

        /* Layout Data (menggunakan float/flexbox sederhana yang didukung DOMPDF) */
        .data-section {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .data-row {
            clear: both;
            margin-bottom: 5px;
        }

        .label {
            float: left;
            width: 30%;
            font-weight: bold;
            color: #555;
        }

        .value {
            float: left;
            width: 68%;
        }
        
        /* Layout Barcode dan Nomor Antrian */
        .footer-info {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 15px;
        }
        
        .barcode-area {
            display: inline-block;
            text-align: center;
            padding: 15px;
            border: 1px solid #000;
        }
        
        .antrian {
            font-size: 14pt;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Jika menggunakan tabel, hapus border */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table td {
            border: none;
            padding: 5px 0;
        }
        .data-table td:first-child {
           width: 35%; /* Mengatur lebar kolom label */
           font-weight: bold;
           color: #555;
       }
       .data-table td:last-child {
        width: 65%;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FORMULIR PENDAFTARAN</h1>
            <p>{{ strtoupper($pendaftaran->nama_kegiatan) }}</p>
            <small>Tanggal Kegiatan: {{ \Carbon\Carbon::parse($pendaftaran->tanggal_kegiatan)->isoFormat('dddd, D MMMM YYYY') }}</small>
        </div>

        <div class="data-section">
            <h3>Informasi Peserta</h3>
            <table class="data-table">
                <tr>
                    <td>Nomor Kartu Keluarga</td>
                    <td>: {{ $pendaftaran->kk }}</td>
                </tr>
                <tr>
                    <td>Nomor KTP</td>
                    <td>: {{ $pendaftaran->ktp }}</td>
                </tr>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>: {{ $pendaftaran->nama }}</td>
                </tr>
                <tr>
                    <td>Alamat Lengkap</td>
                    <td>: {{ $pendaftaran->alamat }}</td>
                </tr>
                <tr>
                    <td>No. WhatsApp</td>
                    <td>: {{ $pendaftaran->whatsapp }}</td>
                </tr>
                <tr>
                    <td>Lansia / Disabilitas</td>
                    <td>: {{ $pendaftaran->lansia_disabilitas }}</td>
                </tr>
            </table>
        </div>
        
        <div class="data-section">
            <h3>Detail Pendaftaran</h3>
            <table class="data-table">
                <tr>
                    <td>Tanggal Pendaftaran</td>
                    <td>: {{ \Carbon\Carbon::parse($pendaftaran->tanggal_pendaftaran)->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>: {{ $pendaftaran->nama_kecamatan }}</td>
                </tr>
            </table>
        </div>

        <div class="footer-info">
            <p>Silakan tunjukkan bagian ini saat registrasi ulang.</p>
            <div class="barcode-area">
                <p>Nomor Antrian Anda:</p>
                <div class="antrian">
                    ** {{ $pendaftaran->antrian ?? '---' }} **
                </div>

                {{-- PASTIKAN UKURAN BERBENTUK PERSEGI UNTUK QR CODE --}}
                @if(isset($url))
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($url) }}">
                @else
                <p style="color: red;">[QR Code tidak tersedia]</p>
                @endif
                <p style="font-size: 8pt; margin: 5px 0 0;">Verifikasi Kode: {{ $pendaftaran->kk }}</p>
            </div>
        </div>

        <div style="margin-top: 50px; text-align: center; font-size: 8pt; color: #777;">
            Dokumen ini dihasilkan secara otomatis. Tidak memerlukan tanda tangan.
        </div>

    </div>
</body>
</html>