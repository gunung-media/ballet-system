@extends('layouts.app')
@section('title', 'Pembayaran Event Form')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran Event" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Pembayaran Event']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data"
        action="{{ isset($data) ? route('installment.update', $data->id) : route('installment.store') }}" method="POST">

        @if (isset($data))
            @method('PUT')
        @endif

        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Pembayaran Event</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <x-fields.input type="text" name="title" label="Nama" :value="$data->title ?? null" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.input type="text" name="total" label="Total" :value="$data->total ?? null"
                                    :is-money="true" />
                            </div>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-warning" href="{{ route('installment.index') }}">Kembali</a>
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    @if (isset($data))
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <div>
                            <h6>Angsuran</h6>
                        </div>
                        <div>
                            <a class="btn btn-primary"
                                href="{{ route('installment.payment.create', ['installmentId' => $data->id]) }}">+ Tambah
                                Data</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <x-table :table-columns="['No', 'Jumlah', 'Nama Siswa', 'Tanggal']" :is-empty="count($data->payments) === 0" id="test">
                            @foreach ($data->payments as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ IntegerUtils::toRupiah($p->amount) }}</td>
                                    <td>{{ $p->student?->name ?? 'N/A' }}</td>
                                    <td>{{ DateUtils::format($p->created_at) }}</td>
                                    <td>
                                        <a href="{{ route('installment.payment.edit', ['installmentId' => $data->id, 'installmentPaymentId' => $p->id]) }}"
                                            class="text-secondary font-weight-bold text-xs btn" data-toggle="tooltip"
                                            data-original-title="Edit user">
                                            Edit
                                        </a>
                                        <form
                                            action="{{ route('installment.payment.destroy', ['installmentId' => $data->id, 'installmentPaymentId' => $p->id]) }}"
                                            method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="px-3 text-danger font-weight-bold text-xs btn"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                </div>
            </div>

        </div>
    @endif
@endsection

@section('customScripts')
@endsection
