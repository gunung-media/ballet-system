<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    .receipt {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        max-width: 400px;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .receipt h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-details p,
    .receipt-summary p {
        margin: 5px 0;
    }

    .receipt-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .receipt-table th,
    .receipt-table td {
        border-bottom: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .receipt-summary {
        text-align: right;
    }

    .receipt-summary p {
        margin: 5px 0;
    }

    .receipt hr {
        margin: 20px 0;
    }

    .receipt p {
        text-align: center;
    }
</style>

<body>
    <div class="receipt">
        <h2>Angelique Ballet</h2>
        <p>CTX, Gg. Kantil Pelem Kecut No.9, Karang Gayam, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa
            Yogyakarta 55281</p>
        <hr>
        <div class="receipt-details">
            <p><strong>Date:</strong> {{ $data->created_at }}</p>
            <p><strong>Receipt No:</strong> {{ $data->id }}</p>
        </div>
        <hr>
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Jenis</th>
                    @if ($data->tuition_type === \App\Enums\TuitionTypeEnum::spp)
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Untuk Bulan</th>
                    @endif
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->tuition_type }}</td>
                    @if ($data->tuition_type === \App\Enums\TuitionTypeEnum::spp)
                        <td>{{ $data->student?->name ?? $data->student_name }}</td>
                        <td>{{ $data->class?->name }}</td>
                        <td>{{ DateUtils::format($data->for_month) }}</td>
                    @endif
                    <td>{{ IntegerUtils::toRupiah($data->amount) }}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="receipt-summary">
            @php
                $diskon = $data->amount * ($data->discount / 100);
            @endphp
            <p><strong>Catatan:</strong> {{ $data->note ?? '-' }} </p>
            <p><strong>Subtotal:</strong> {{ IntegerUtils::toRupiah($data->amount) }}</p>
            <p><strong>Diskon ({{ $data->discount ?? 0 }}%):</strong>
                {{ IntegerUtils::toRupiah($diskon) }}
            </p>
            <p><strong>Total:</strong> {{ IntegerUtils::toRupiah($data->amount - $diskon) }}</p>
        </div>
        <hr>
        <p>Thank you for your business!</p>
    </div>
</body>

</html>

<script>
    window.print();
</script>
