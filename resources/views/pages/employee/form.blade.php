@extends('layouts.app')
@section('title', 'Staf Form')
@section('sidebar')
    <x-sidebar active-menu="Data Staf" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Staf']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data"
        action="{{ isset($data) ? route('pegawai.update', $data->id) : route('pegawai.store') }}" method="POST">

        @if (isset($data))
            @method('PUT')
        @endif

        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Staf</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <x-fields.input type="text" name="name" label="Name" :value="$data->name ?? null" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.select name="gender" label="Jenis Kelamin" :choices="$genders" :value="$data->gender ?? null" />
                            </div>
                        </div>

                        <x-fields.input type="email" name="email" label="Email" :value="$data->email ?? null" :is-required="false" />


                        <x-fields.input type="file" name="photo" label="Foto Staf" :is-required="!isset($data) || empty($data->photo)" />

                        @if ($data->photo ?? false)
                            <div>
                                <img src="{{ asset('storage/' . $data->photo) }}" alt="{{ $data->name }}" />
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <a class="btn btn-warning" href="{{ route('pegawai.index') }}">Kembali</a>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection

@section('customScripts')
@endsection
