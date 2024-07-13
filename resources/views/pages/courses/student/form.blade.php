@extends('layouts.app')
@section('title', 'Siswa Form')
@section('sidebar')
    <x-sidebar active-menu="Data Siswa" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Siswa']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data"
        action="{{ isset($data) ? route('siswa.update', $data->id) : route('siswa.store') }}" method="POST">
        @if (isset($data))
            @method('PUT')
        @endif

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
                                <x-fields.input type="text" name="name" label="Nama Lengkap"
                                    value="{{ $data->name ?? null }}" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.input type="text" name="surname" label="Nama Panggilan"
                                    value="{{ $data->surname ?? null }}" :is-required="false" />
                            </div>

                            <div class="col-12">
                                <x-fields.select name="gender" label="Jenis Kelamin" :choices="$genders"
                                    value="{{ $data->gender ?? null }}" />
                            </div>
                        </div>

                        <x-fields.input type="date" name="birth_date" label="Tanggal Lahir"
                            value="{{ $data->birth_date ?? null }}" />

                        <x-fields.input type="text" name="address" label="Alamat" value="{{ $data->address ?? null }}"
                            :is-required="false" />


                        <div class="row">
                            <div class="col-md-6 col-12">
                                <x-fields.input type="email" name="email" label="Email"
                                    value="{{ $data->email ?? null }}" :is-required="false" />
                            </div>

                            <div class="col-md-6 col-12">
                                <x-fields.input type="tel" name="phone" label="No. Telepon"
                                    value="{{ $data->phone ?? null }}" :is-required="false" />
                            </div>
                        </div>

                        <x-fields.input type="file" name="photo" label="Foto Siswa" :is-required="!isset($data) || empty($data->photo)" />

                        @if ($data->photo ?? false)
                            <div>
                                <img src="{{ asset('storage/' . $data->photo) }}    " alt="{{ $data->name }}" />
                            </div>
                        @endif
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
                        <x-fields.input type="text" name="wali_name" label="Nama Wali"
                            value="{{ $data->wali_name ?? null }}" :is-required="false" />
                        <x-fields.input type="tel" name="wali_phone" label="Nomor Wali/Kontak Darurat"
                            value="{{ $data->wali_phone ?? null }}" :is-required="false" />
                        <br />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div action="">
                        <x-fields.select name="classes[]" label="Kelas" :choices="$classes" :is-multiple="true"
                            :value="isset($selectedClass) ? $selectedClass : null" />

                        <x-fields.input type="date" name="registration" label="Tanggal Pendaftaran"
                            value="{{ $data->registration ?? null }}" :is-required="false" />

                        <x-fields.input type="text" name="note" label="Catatan" value="{{ $data->note ?? null }}"
                            :is-required="false" />

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
