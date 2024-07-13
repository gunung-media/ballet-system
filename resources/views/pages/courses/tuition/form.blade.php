@extends('layouts.app')
@section('title', 'SPP Form')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran SPP" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data SPP']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data"
        action="{{ isset($data) ? route('spp.update', $data->id) : route('spp.store') }}" method="POST">

        @if (isset($data))
            @method('PUT')
        @endif

        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data SPP</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.select name="student_id" label="Siswa" :choices="$students" :value="$data->student?->id ?? null"
                            :is-required="false" :is-tuition="true" />

                        <x-fields.select name="class_id" label="Pilih Kelas" :choices="$defaultClasses" :value="$data->class_id ?? null"
                            :is-required="true" />

                        <x-fields.input type="number" name="amount" label="Jumlah Pembayaran" :value="$data->amount ?? null"
                            :is-money="true" hint-text="Maximal 100000" />

                        <x-fields.input type="month" name="for_month" label="Untuk Bulan" :value="$data->for_month ?? null" />
                    </div>

                    <div class="form-group">
                        <a class="btn btn-warning" href="{{ route('spp.index') }}">Kembali</a>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection

@section('customScripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedClass = document.querySelector('select[name="class_id"]');

            selectedClass.addEventListener('change', function() {
                console.log(selectedClass.value);
            });
        });
    </script>
@endsection
