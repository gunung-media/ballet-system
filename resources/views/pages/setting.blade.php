@extends('layouts.app')
@section('title', 'Pengaturan')
@section('sidebar')
    <x-sidebar active-menu="Pengaturan" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Pengaturan']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data" action="{{ route('setting.store') }}" method="POST">
        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Pengaturan</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.input type="text" name="receipt_title" label="Nama Studio" :value="$data->receipt_title ?? null"
                            hint-text="Untuk Kwintansi" />

                        <x-fields.input type="text" name="receipt_address" label="Alamat " :value="$data->receipt_address ?? null" />

                        <x-fields.input type="text" name="receipt_text_footer" label="Thankyou Text" :value="$data->receipt_text_footer ?? null" />

                        <x-fields.input type="file" name="receipt_logo" label="Logo" :is-required="!isset($data) || empty($data->receipt_logo)" />

                        @if ($data->receipt_logo ?? false)
                            <div>
                                <img src="{{ asset('storage/' . $data->receipt_logo) }}" alt="{{ $data->receipt_title }}" />
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection

@section('customScripts')
@endsection
