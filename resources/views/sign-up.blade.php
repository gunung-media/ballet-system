@extends('layouts.auth-app')

@section('content')
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('../assets/img/curved-images/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Pendaftaran Siswa</h1>
                    <p class="text-lead text-white">Silahkan Isi Form Ini dengan Sebenar-benarnyr</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-lg-10 col-md-12 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <center class="mt-2 mb-5">
                            <img src="{{ asset('assets/img/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
                            <span class="font-weight-bold">Angelique Ballet</span>
                        </center>
                        <form role="form text-left" action="{{ route('auth.register.post') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

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
                                    <x-fields.input type="tel" name="phone" label="No. Telepon" />
                                </div>
                            </div>

                            <x-fields.input type="file" name="photo" label="Foto Siswa" :is-required="!isset($data) || empty($data->photo)" />

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <x-fields.input type="text" name="wali_name" label="Nama Wali" />
                                </div>

                                <div class="col-md-6 col-12">
                                    <x-fields.input type="tel" name="wali_phone" label="Nomor Wali/Kontak Darurat" />

                                    <x-fields.input type="hidden" name="registration" label="Tanggal Pendaftaran"
                                        value="{{ now() }}" />

                                    <x-fields.input type="hidden" name="note" label="Tanggal Pendaftaran"
                                        value="Daftar dari web" />
                                </div>
                            </div>
                            <br />



                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                                    checked>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and
                                        Conditions</a>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
