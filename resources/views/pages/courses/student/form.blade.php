@extends('layouts.app')
@section('title', 'Siswa Form')
@section('sidebar')
    <x-sidebar active-menu="Data Siswa" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Siswa']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data" action="{{ route('siswa.store') }}" method="POST">
        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Siswa</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
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


                        <div class="row">
                            <div class="col-md-6 col-12">
                                <x-fields.input type="email" name="email" label="Email" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.input type="tel" name="phone" label="No. Telepon " />
                            </div>
                        </div>

                        <x-fields.input type="file" name="photo" label="Foto Siswa" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Wali</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.input type="text" name="wali_name" label="Nama Wali" />
                        <x-fields.input type="tel" name="wali_phone" label="Nomor Wali/Kontak Darurat" />
                        <br />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div action="">
                        <x-fields.input type="date" name="registration" label="Tanggal Pendaftaran" />

                        <x-fields.input type="text" name="note" label="Catatan" />

                        <hr />

                        <div class="form-group">
                            <a class="btn btn-warning" href="{{ route('siswa.index') }}">Kembali</a>
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('customScripts')
@endsection
