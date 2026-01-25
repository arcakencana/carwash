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
            margin-top: 10px;
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 10px;
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
    .kop-surat {
        width: 100%;
        display: flex;
        align-items: center; /* <-- ini yang bikin logo & teks sejajar */
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-bottom: 3px solid #000; /* <-- GARIS BAWAH */
    }

    .kop-logo {
        width: 10px;
        height: 10px;
        object-fit: contain;
        margin-right: 20px;
    }

    .kop-text {
        flex: 1;
        text-align: center;
        line-height: 1.3;
    }

    .kop-text h2, 
    .kop-text h3, 
    .kop-text p {
        margin: 0;
        padding: 0;
    }
</style>
</head>
<body>
    <div class="container">

        <div class="kop-surat">
            {{-- <img src="{{ asset('images/logo.png') }}" class="kop-logo" alt="Logo"> --}}

            <div class="kop-text">
                <h2>PEMERINTAH KOTA BATAM</h2>
                <h3>DINAS PERINDUSTRIAN DAN PERDAGANGAN</h3>
                <p>Jl. Raja Isa No. 17 Lt.5 Kantor Bersama, Kota Batam</p>
                <p>Telp: (0778) 4168417 – Email: disperindag.batam@batam.go.id</p>
            </div>
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
                <tr>
                    <td>Kelurahan</td>
                    <td>: {{ $pendaftaran->nama_kelurahan }}</td>
                </tr>
                <tr>
                    <td>Lokasi Pembelian</td>
                    <td>: {{ $pendaftaran->lokasi }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>: {{ \App\Helpers\Helper::getJamAntrian($pendaftaran->antrian) }}</td>
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
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=125x125&data={{ urlencode($url) }}">
                @else
                <p style="color: red;">[QR Code tidak tersedia]</p>
                @endif
                {{-- <p style="font-size: 8pt; margin: 5px 0 0;">Verifikasi Kode: {{ $pendaftaran->kk }}</p> --}}
            </div>
        </div>

        <div style="margin-top: 10px; text-align: left; font-size: 8pt; color: #777;">
            Keterangan :<br>
            1. Peserta wajib datang langsung dengan membawa KTP / KK Asli sesuai data pendaftaran diatas.<br>
            2. Membawa uang Rp. 100,000 untuk pembelian paket barang kebutuhan pokok senilai Rp. 200,000 pada kegiatan Pasar Murah Bersubsidi.
        </div>

    </div>
</body>
</html>