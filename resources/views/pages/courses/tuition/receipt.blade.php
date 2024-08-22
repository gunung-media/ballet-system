@php
    $isBulk = $data instanceof \Illuminate\Database\Eloquent\Collection;
    $theAmount = $isBulk ? 0 : $data->amount;
@endphp
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
        max-width: {{ $isBulk ? '600px' : '400px' }};
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

    .info p {
        text-align: left !important;
        margin: 0px
    }
</style>

<body>
    <div class="receipt">
        <h2>Angelique Ballet</h2>
        <p>CTX, Gg. Kantil Pelem Kecut No.9, Karang Gayam, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah
            Istimewa
            Yogyakarta 55281</p>
        <hr>
        <div class="receipt-details">
            <p><strong>Date:</strong> {{ $isBulk ? $data[0]->created_at : $data->created_at }}</p>
            @if ($isBulk)
                <p><strong>Total Item:</strong> {{ $data->count() }}</p>
            @else
                <p><strong>Receipt No:</strong> {{ $isBulk ? $data[0]->id : $data->id }}</p>
            @endif
        </div>
        <hr>
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Info</th>
                    @if ($isBulk)
                        <th>Jumlah</th>
                        <th>Diskon</th>
                    @endif
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @if ($isBulk)
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->tuition_type }}</td>
                            <td class="info">
                                @if ($d->tuition_type === \App\Enums\TuitionTypeEnum::spp)
                                    <p><strong>Nama Siswa:</strong> {{ $d->student?->name ?? $d->student_name }}
                                    </p>
                                    <p><strong>Nama Kelas:</strong> {{ $d->class?->name }}</p>
                                    <p><strong>Untuk Bulan:</strong>
                                        {{ DateUtils::format($d->for_month, false, true) }}</p>
                                    <p><strong>Catatan :</strong> {{ $d->note ?? '-' }}</p>
                                @else
                                    <p><strong>Catatan :</strong> {{ $d->note ?? '-' }}</p>
                                @endif
                            </td>
                            <td>{{ IntegerUtils::toRupiah($d->amount) }}</td>
                            <td>{{ $d->discount ?? 0 }}%</td>
                            @php
                                $diskon = $d->amount * ($d->discount / 100);
                                $theAmount += $d->amount - $diskon;
                            @endphp
                            <td>{{ IntegerUtils::toRupiah($d->amount - $diskon) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $data->tuition_type }}</td>
                        <td class="info">
                            @if ($data->tuition_type === \App\Enums\TuitionTypeEnum::spp)
                                <p><strong>Nama Siswa:</strong> {{ $data->student?->name ?? $data->student_name }}
                                </p>
                                <p><strong>Nama Kelas:</strong> {{ $data->class?->name }}</p>
                                <p><strong>Untuk Bulan:</strong>
                                    {{ DateUtils::format($data->for_month, false, true) }}
                                </p>
                                <p><strong>Catatan :</strong> {{ $data->note ?? '-' }}</p>
                            @else
                                <p><strong>Catatan :</strong> {{ $data->note ?? '-' }}</p>
                            @endif
                        </td>
                        <td>{{ IntegerUtils::toRupiah($data->amount) }}</td>
                    </tr>

                @endif
            </tbody>
        </table>
        <hr>

        <div class="receipt-summary">
            @if (!$isBulk)
                @php
                    $diskon = $data->amount * ($data->discount / 100);
                @endphp
                <!-- <p><strong>Catatan:</strong> {{ $data->note ?? '-' }} </p> -->
                <p><strong>Subtotal:</strong> {{ IntegerUtils::toRupiah($data->amount) }}</p>
                @if (!is_null($data->discount))
                    <p>
                        <strong>Diskon ({{ $data->discount ?? 0 }}%):</strong>
                        {{ IntegerUtils::toRupiah($diskon) }}
                    </p>
                @endif
                <p><strong>Total:</strong> {{ IntegerUtils::toRupiah($data->amount - $diskon) }}</p>
            @else
                <p><strong>Total:</strong> {{ IntegerUtils::toRupiah($theAmount) }}</p>
            @endif
        </div>
        <hr>
        <p>Thank you for your business!</p>
    </div>
</body>

</html>

<script></script>
