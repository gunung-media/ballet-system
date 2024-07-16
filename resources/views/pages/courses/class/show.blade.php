@extends('layouts.app')
@section('title', 'Detail Kehadiran Siswa')
@section('sidebar')
    <x-sidebar active-menu="Data Kelas" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Kelas', 'Detail Kehadiran Siswa']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Detail Kehadiran Siswa</h6>
                        <p class="font-weight-light text-xs">Berikut data kehadiran siswa yang ada di Sistem</p>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-table :table-columns="[
                        'No',
                        'Nama',
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                    ]" :is-empty="count($data) == 0" :is-sortable="false" :freeze-columns="['No', 'Nama']">
                        @foreach ($data as $key => $d)
                            <tr>
                                <td class="sticky-col first-col">{{ $key + 1 }}</td>
                                <td class="sticky-col second-col">{{ $d->name }}</td>
                                @php
                                    $absenceData = $getStudentByAbsence($d->id);
                                @endphp
                                @foreach ($absenceData as $key => $absence)
                                    <td>{{ $absence }}</td>
                                @endforeach
                            </tr>
                        @endforeach

                    </x-table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
@endsection
