<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: DejaVu Sans;
        font-size: 12px;
        color: #000;
        margin: 40px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .subtitle {
        font-size: 12px;
        color: #555;
    }

    .line {
        border-bottom: 2px solid #000;
        margin: 15px 0 25px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    td, th {
        border: 1px solid #000;
        padding: 8px;
    }

    .no-border td {
        border: none;
        padding: 4px;
    }

    .section-title {
        margin-top: 25px;
        font-weight: bold;
        font-size: 14px;
    }

    .sign-box {
        height: 90px;
        text-align: center;
        vertical-align: bottom;
    }

    .footer {
        margin-top: 40px;
        font-size: 11px;
        text-align: right;
    }
</style>
</head>
<body>

<div class="header">
    <div class="title">BUKTI PEMINJAMAN BARANG</div>
    <div class="subtitle">Sistem Inventaris Sekolah</div>
</div>

<div class="line"></div>

<table class="no-border">
<tr>
    <td width="150">Nama Peminjam</td>
    <td>: {{ $lending->name }}</td>
</tr>
<tr>
    <td>Nama Barang</td>
    <td>: {{ $lending->item->name }}</td>
</tr>
<tr>
    <td>Jumlah</td>
    <td>: {{ $lending->total }}</td>
</tr>
<tr>
    <td>Tanggal Pinjam</td>
    <td>: {{ date('d M Y', strtotime($lending->created_at)) }}</td>
</tr>
<tr>
    <td>Tanggal Kembali</td>
    <td>: {{ $lending->returned_at ? date('d M Y', strtotime($lending->returned_at)) : '-' }}</td>
</tr>
</table>

<div class="section-title">TANDA TANGAN PEMINJAMAN</div>
<table>
<tr>
    <th>Operator 1</th>
    <th>Operator 2</th>
    <th>Peminjam 1</th>
    <th>Peminjam 2</th>
</tr>
<tr class="sign-box">
    <td>@if($lending->operator_sign_1)<img src="{{ $lending->operator_sign_1 }}" height="70">@endif</td>
    <td>@if($lending->operator_sign_2)<img src="{{ $lending->operator_sign_2 }}" height="70">@endif</td>
    <td>@if($lending->borrower_sign_1)<img src="{{ $lending->borrower_sign_1 }}" height="70">@endif</td>
    <td>@if($lending->borrower_sign_2)<img src="{{ $lending->borrower_sign_2 }}" height="70">@endif</td>
</tr>
</table>

<div class="section-title">TANDA TANGAN PENGEMBALIAN</div>
<table>
<tr>
    <th>Operator 1</th>
    <th>Operator 2</th>
    <th>Peminjam 1</th>
    <th>Peminjam 2</th>
</tr>
<tr class="sign-box">
    <td>@if($lending->return_operator_sign_1)<img src="{{ $lending->return_operator_sign_1 }}" height="70">@endif</td>
    <td>@if($lending->return_operator_sign_2)<img src="{{ $lending->return_operator_sign_2 }}" height="70">@endif</td>
    <td>@if($lending->return_borrower_sign_1)<img src="{{ $lending->return_borrower_sign_1 }}" height="70">@endif</td>
    <td>@if($lending->return_borrower_sign_2)<img src="{{ $lending->return_borrower_sign_2 }}" height="70">@endif</td>
</tr>
</table>

<div class="footer">
    Dicetak pada: {{ date('d M Y H:i') }}
</div>

</body>
</html>
