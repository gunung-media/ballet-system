@extends('layouts.app')
@section('title', 'Angsuran Form')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran Event" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Pembayaran Event', 'Angsuran']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data"
        action="{{ isset($data) ? route('installment.payment.update', ['installmentId' => $installmentId, 'installmentPaymentId' => $data->id]) : route('installment.payment.store', ['installmentId' => $installmentId]) }}"
        method="POST">

        @if (isset($data))
            @method('PUT')
        @endif

        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Angsuran</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <x-fields.input type="text" name="amount" label="Jumlah" :value="$data->amount ?? null" :is-money="true" />

                    <div class="form-group">
                        <a class="btn btn-warning" href="{{ route('installment.edit', $installmentId) }}">Kembali</a>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('customScripts')
@endsection
