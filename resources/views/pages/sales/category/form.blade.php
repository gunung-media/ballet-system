@extends('layouts.app')
@section('title', 'Kategori Form')
@section('sidebar')
    <x-sidebar active-menu="Kategori" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Penjualan', 'Kategori']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Form Kategori</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="form-group">
                            <label>Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Gambar Kategori</label>
                            <input type="file" class="form-control">
                        </div>

                        <hr />

                        <div class="form-group">
                            <a class="btn btn-warning" href="{{ route('kategori.index') }}">Kembali</a>
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
@endsection
