@extends('layouts.app')
@section('title', 'Guru Form')
@section('sidebar')
    <x-sidebar active-menu="Data Guru" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Guru']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data" action="{{ route('guru.store') }}" method="POST">
        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Guru</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.input type="text" name="identity_number" label="NIK" />
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <x-fields.input type="text" name="name" label="Name" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.select name="gender" label="Jenis Kelamin" :choices="$genders" />
                            </div>
                        </div>

                        <x-fields.input type="date" name="birth_date" label="Tanggal Lahir" />

                        <x-fields.input type="text" name="address" label="Alamat" />

                        <x-fields.select name="status" label="Status" :choices="$status" />

                        <x-fields.input type="date" name="join_date" label="Tanggal Masuk" />

                        <div class="row">
                            <div class="col-md-6 col-12">
                                <x-fields.input type="email" name="email" label="Email" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.input type="tel" name="phone" label="No. Telepon " />
                            </div>
                        </div>

                        <x-fields.input type="file" name="photo" label="Foto Guru" />
                    </div>

                    <div class="form-group">
                        <a class="btn btn-warning" href="{{ route('siswa.index') }}">Kembali</a>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection

@section('customScripts')
@endsection
