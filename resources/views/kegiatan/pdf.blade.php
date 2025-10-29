<!DOCTYPE html>
<html>
<head>
    <title>{{ $kegiatan->nama_kegiatan }}</title>
    <style>
        body { font-family: sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">{{ $kegiatan->nama_kegiatan }}</h2>
    @if($kegiatan->banner)
    <img src="{{ public_path('storage/' . $kegiatan->banner) }}" style="width:70%; object-fit:cover; text-align: center;">
    @endif
    <br>
    <h2 style="text-align: center;">Tanggal {{ date('d-m-Y', strtotime($kegiatan->tanggal_kegiatan)) }}</h2>
    <h2 style="text-align: center;">Kuota {{ $kegiatan->kuota_peserta }}</h2>
    <p>{{ $kegiatan->deskripsi }}</p>
</body>
</html>
