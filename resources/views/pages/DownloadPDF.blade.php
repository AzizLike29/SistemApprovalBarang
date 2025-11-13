<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Download PDF</title>

    <style>
        @page {
            margin: 30mm 20mm 20mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            height: 60px;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #e9ecef;
            display: table-header-group;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('assets/img/wings.png') }}" alt="Logo">
        <h2>PT. Prakarsa Alam Segar</h2>
        <p>Laporan History Barang Sistem Approval</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 90px;">Waktu</th>
                <th style="width: 90px;">Pengguna</th>
                <th style="width: 80px;">Aksi</th>
                <th style="width: 90px;">Modul</th>
                <th style="width: 50px;">Ref</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $row)
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($row->waktu)->format('Y-m-d H:i') }}</td>
                    <td>{{ $row->user_nama ?? '—' }}</td>
                    <td class="text-center">{{ strtoupper($row->action) }}</td>
                    <td class="text-center">{{ $row->module }}</td>
                    <td class="text-center">{{ $row->ref_id ?? '—' }}</td>
                    <td>
                        {{ $row->description }}
                        @if (!empty($row->alasan))
                            <div class="small"><em>Alasan:</em> {{ $row->alasan }}</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <div class="text-center small">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>
</body>

</html>
