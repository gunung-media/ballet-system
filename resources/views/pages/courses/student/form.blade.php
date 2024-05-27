@extends('layouts.app')
@section('title', 'Siswa Form')
@section('sidebar')
    <x-sidebar active-menu="Data Siswa" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Siswa']" />
@endsection
@section('content')
    <form class="row">
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
                            <div class="form-group col-md-6 col-12">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="" id="" class="form-control">
                                    <option value="">Pria</option>
                                    <option value="">Wanita</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Alamat<span class="text-danger">*</span></label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" required>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>No. Telepon <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Foto Siswa</label>
                            <input type="file" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Wali</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span>
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <div class="form-group">
                            <label>Nama Kontak Darurat<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Wali<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor Wali/Kontak Darurat<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" required>
                        </div>

                        <br />
                        <br />
                        <br />

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div action="">
                        <div class="form-group">
                            <label>Kursus Yang Diikuti<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Pendaftaran<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Jadwal Kelas<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Catatan<span class="text-danger">*</span></label>
                            <textarea name="" id="" class="form-control"></textarea>
                        </div>

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
