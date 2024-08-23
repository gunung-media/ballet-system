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

    .receipt img {
        max-width: 200px;
        max-height: 100px;
        margin-bottom: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
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

    .info p {
        text-align: left !important;
        margin: 0px
    }
</style>

<body>
    <div class="receipt">
        <img src="{{ asset('storage/' . $setting?->receipt_logo) }}" alt="{{ $setting?->receipt_title }}" />
        <h2>{{ $setting?->receipt_title ?? 'Angelique Ballet' }}</h2>
        <p>{{ $setting?->receipt_address ?? 'CTX, Gg. Kantil Pelem Kecut No.9, Karang Gayam, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281' }}
        </p>
        <hr>
        <div class="receipt-details">
            <p><strong>Nama Event:</strong> {{ $data->title }}</p>
            <p><strong>Total:</strong> {{ IntegerUtils::toRupiah($data->total) }}</p>
            <p><strong>Date:</strong> {{ $data->created_at }}</p>
        </div>
        <hr>
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Ssiwa</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sum = 0;
                @endphp
                @foreach ($data->payments as $p)
                    @php
                        $sum += $p->amount;
                    @endphp
                    <tr>
                        <td>{{ DateUtils::format($p->created_at) }}</td>
                        <td>{{ $p->student->name ?? 'N/A' }}</td>
                        <td>{{ IntegerUtils::toRupiah($p->amount) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr>

        <div class="receipt-summary">
            <p><strong>Total:</strong> {{ IntegerUtils::toRupiah($sum) }}</p>
        </div>
        <hr>
        <p>{{ $setting?->receipt_text_footer ?? 'Thank you for using our application ' }}</p>
    </div>
</body>

</html>

<script>
    window.print()
</script>
