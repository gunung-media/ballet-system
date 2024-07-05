@extends('layouts.app')
@section('title', 'Presensi Pegawai')
@section('sidebar')
    <x-sidebar active-menu="Absensi Pegawai" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Absensi Pegawai']" />
@endsection
@section('content')
    <div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    @php
                        use Carbon\Carbon;
                        $date = Carbon::parse($date);
                        $formattedDate = $date->translatedFormat('l, d F Y');
                        $shouldDisable = $date->endOfDay()->isPast() ? 'disabled' : '';
                    @endphp
                    <h5>{{ $formattedDate }}</h5>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    <h6>Daftar Pegawai</h6>
                </div>
                @if (!empty($employees))
                    <div class="card-body">
                        <div class="row">
                            @foreach ($employees as $employee)
                                <form class="col-md-4 col-12" action="{{ route('pegawai.absence.form.submit') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="employee_id" value="{{ $employee?->id }}">
                                    <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                                class="img-fluid border-radius-lg card-img">
                                            <p class="card-title d-block text-darker text-center h5 pt-3">
                                                {{ $employee->name }}
                                                <span
                                                    class="text-sm font-weight-light">{{ $getEmployeeState($employee->id) ?? '' }}</span>
                                            </p>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="submit" name="state" value="Hadir"
                                                        class="btn btn-success w-100 btn-tooltip" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Saya Hadir" data-container="body"
                                                        data-animation="true" {{ $shouldDisable }}>
                                                        <span class="btn-inner--icon"><i class="ni ni-active-40"></i></span>
                                                        <span class="btn-inner--text">Hadir</span>
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="submit" name="state" value="Tidak Hadir"
                                                        class="btn btn-danger w-100 btn-tooltip" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Saya Tidak Hadir"
                                                        data-container="body" data-animation="true" {{ $shouldDisable }}>
                                                        <span class="btn-inner--icon"><i class="ni ni-user-run"></i></span>
                                                        <span class="btn-inner--text">Tidak Hadir</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('customStyles')
    <style>
        .img-custom {
            max-width: 500px;
            max-height: 250px;
        }
    </style>
@endsection
