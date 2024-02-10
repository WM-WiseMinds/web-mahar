<div>
    <h2>  Barang Table</h2>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid; padding: 8px;">ID</th>
                <th style="border: 1px solid; padding: 8px;">Nama Barang</th>
                {{-- <th style="border: 1px solid; padding: 8px;">gambar</th> --}}
                <th style="border: 1px solid; padding: 8px;">keterangan</th>
                <th style="border: 1px solid; padding: 8px;">Status</th>
                <th style="border: 1px solid; padding: 8px;">Total Terjual</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($datasource as $barang)
            <tr>
                <td style="border: 1px solid; padding: 8px;">{{ $barang->id }}</td>
                <td style="border: 1px solid; padding: 8px;">{{ $barang->nama_barang }}</td>
                {{-- <td style="border: 1px solid; padding: 8px;">{{ $barang->gambar }}</td> --}}
                <td style="border: 1px solid; padding: 8px;">{{ $barang->keterangan }}</td>
                <td style="border: 1px solid; padding: 8px;">{{ $barang->status }}</td>
                <td style="border: 1px solid; padding: 8px;">{{ $barang->total_terjual }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>