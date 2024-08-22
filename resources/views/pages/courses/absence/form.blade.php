@extends('layouts.app')
@section('title', 'Presensi Form')
@section('sidebar')
    <x-sidebar active-menu="Data Presensi" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Presensi']" />
@endsection
@section('content')
    <div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    @php
                        use Carbon\Carbon;
                        $date = Carbon::parse($date);
                        $formattedDate = $date->translatedFormat('l, d F Y, H:i');
                        $shouldDisable = is_null($absence) && $date->startOfDay()->isPast() ? 'disabled' : '';
                    @endphp
                    <h5>{{ $class->name }}</h5>
                    <p class="font-weight-light text-sm">Tanggal: {{ $formattedDate }}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('absence.form.submit') }}" method="POST">
                        @csrf
                        <x-fields.select name="teacher_id" label="Guru" :choices="$teachers" :is-enabled="is_null($absence) && !$date->isPast()"
                            :value="$absence?->teacher_id ?? null" />
                        @if (is_null($absence) && !$date->startOfDay()->isPast())
                            <input name="date" value="{{ $date }}" type="hidden">
                            <input name="class_schedule_id" value="{{ $scheduleId }}" type="hidden">
                            <input type="hidden" value="true" name="is_submit">
                            <div class="form-group">
                                <button class="btn btn-success">Simpan</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    <h6>Daftar Siswa </h6>
                </div>
                @if (!empty($students))
                    <div class="card-body">
                        <div class="row">
                            @foreach ($students as $student)
                                <form class="col-md-4 col-12" action="{{ route('absence.form.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="absence_id" value="{{ $absence?->id }}">
                                    <input type="hidden" name="student_id" value="{{ $student?->id }}">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <img src="{{ asset('storage/' . $student->photo) }}"
                                                class="img-fluid border-radius-lg card-img img-absence">
                                            <p class="card-title d-block text-darker text-center h5 pt-3">
                                                {{ $student->name }}
                                                @if (!is_null($absence))
                                                    <span
                                                        class="text-sm font-weight-light">{{ $getStudentState($student->id) ?? '' }}</span>
                                                @endif
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
                                                <!-- <div class="col-6"> -->
                                                <!--     <button type="submit" name="state" value="Ijin" -->
                                                <!--         class="btn btn-warning w-100 btn-tooltip" data-bs-toggle="tooltip" -->
                                                <!--         data-bs-placement="top" title="Saya Ijin" data-container="body" -->
                                                <!--         data-animation="true" {{ $shouldDisable }}> -->
                                                <!--         <span class="btn-inner--icon"><i class="ni ni-planet"></i></span> -->
                                                <!--         <span class="btn-inner--text">Ijin</span> -->
                                                <!--     </button> -->
                                                <!-- </div> -->
                                                <!-- <div class="col-6"> -->
                                                <!--     <button type="submit" name="state" value="Sakit" -->
                                                <!--         class="btn btn-primary w-100 btn-tooltip" data-bs-toggle="tooltip" -->
                                                <!--         data-bs-placement="top" title="Saya Sakit" data-container="body" -->
                                                <!--         data-animation="true" {{ $shouldDisable }}> -->
                                                <!--         <span class="btn-inner--icon"><i class="ni ni-diamond"></i></span> -->
                                                <!--         <span class="btn-inner--text">Sakit</span> -->
                                                <!--     </button> -->
                                                <!-- </div> -->
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
