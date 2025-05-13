<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $salary->employee->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .company-info {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .slip-title {
            font-size: 16px;
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 8px;
            margin: 20px 0 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .employee-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .employee-info td {
            padding: 5px;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .salary-table th,
        .salary-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .salary-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signature {
            margin-top: 30px;
            float: right;
            width: 200px;
            text-align: center;
        }

        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            margin-bottom: 5px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-info">PT. WEB KARYAWAN</div>
        <p>Jl. Contoh No. 123, Jakarta Selatan</p>
        <p>Telepon: 021-123456789 | Email: info@web-karyawan.com</p>
    </div>

    <div class="slip-title">SLIP GAJI KARYAWAN</div>

    <table class="employee-info">
        <tr>
            <td width="120px">Nama Karyawan</td>
            <td width="10px">:</td>
            <td><strong>{{ $salary->employee->user->name }}</strong></td>
            <td width="120px">Periode</td>
            <td width="10px">:</td>
            <td><strong>{{ $salary->period }}</strong></td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $salary->employee->nip }}</td>
            <td>Tanggal Slip</td>
            <td>:</td>
            <td>{{ now()->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $salary->employee->position }}</td>
            <td>Departemen</td>
            <td>:</td>
            <td>{{ $salary->employee->department }}</td>
        </tr>
    </table>

    <table class="salary-table">
        <tr>
            <th colspan="2">RINCIAN PENDAPATAN</th>
        </tr>
        <tr>
            <td width="60%">Gaji Pokok</td>
            <td>Rp {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bonus</td>
            <td>Rp {{ number_format($salary->bonus, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th colspan="2">RINCIAN POTONGAN</th>
        </tr>
        <tr>
            <td>Potongan Ketidakhadiran ({{ $salary->absence_count }} hari)</td>
            <td>Rp {{ number_format($salary->deduction, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td>TOTAL DITERIMA</td>
            <td>{{ $salary->formatted_total_salary }}</td>
        </tr>
    </table>

    <div>
        <p><strong>Kehadiran:</strong></p>
        <ul>
            <li>Jumlah hari kerja: {{ $salary->attendance_count + $salary->absence_count }} hari</li>
            <li>Hadir: {{ $salary->attendance_count }} hari</li>
            <li>Tidak Hadir/Alpha: {{ $salary->absence_count }} hari</li>
        </ul>
    </div>

    <div class="clearfix">
        <div class="signature">
            <p>Jakarta, {{ now()->format('d F Y') }}</p>
            <p>Bendahara</p>
            <div class="signature-line"></div>
            <p><strong>HRD PT. Web Karyawan</strong></p>
        </div>
    </div>

    <div class="footer">
        <p>Slip gaji ini diterbitkan secara elektronik dan sah tanpa tanda tangan basah.</p>
        <p>Jika ada pertanyaan mengenai slip gaji ini, hubungi bagian HRD dalam waktu 7 hari setelah diterima.</p>
    </div>
</body>

</html>
