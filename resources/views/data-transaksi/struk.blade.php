<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk #{{ $transaksi->kode_transaksi }}</title>
    <style>
        body { font-family: monospace; width: 300px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px; }
        th { border-bottom: 1px dashed #000; }
        .right { text-align: right; }
        .center { text-align: center; }
        .mt-4 { margin-top: 16px; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="center" style="line-height:1.2; margin-bottom:5px;">
        <h3 style="margin:0; padding:0; font-size:14px;">{{ env('APP_NAME') }}</h3>
        <p style="margin:0; padding:0; font-size:12px;">Transaksi #{{ $transaksi->kode_transaksi }}</p>
        <p style="margin:0; padding:0; font-size:12px;">No Polisi #{{ $transaksi->no_polisi }}</p>
        <p style="margin:0; padding:0; font-size:12px;">{{ date('d-m-Y', strtotime($transaksi->tanggal)) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->barang->nama }}</td>
                <td class="right">{{ $item->qty }}</td>
                <td class="right">{{ number_format($item->harga,0,',','.') }}</td>
                <td class="right">{{ number_format($item->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="right font-bold">Total</td>
                <td class="right font-bold">{{ number_format($transaksi->total_harga,0,',','.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="center mt-4">
        Terima Kasih!
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
