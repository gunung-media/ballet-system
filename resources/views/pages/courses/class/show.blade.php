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
                <div class="card-header pb-0">
                    <h6>Jumlah Kelas</h6>
                </div>
                <div class="card-body">

                    @php
                        $months = [
                            9 => 'September',
                            10 => 'October',
                            11 => 'November',
                            12 => 'December',
                            1 => 'January',
                            2 => 'February',
                            3 => 'March',
                            4 => 'April',
                            5 => 'May',
                            6 => 'June',
                            7 => 'July',
                            8 => 'August',
                        ];
                    @endphp
                    <x-table :is-sortable="false" :table-columns="['Nama', 'Jumlah']" id="month" :per-page="12">
                        @foreach ($months as $monthNumber => $monthName)
                            @php
                                $sum = $getClassAbsences($monthNumber);
                            @endphp
                            <tr>
                                <td>{{ $monthName }}</td>
                                <td>{{ $sum }}</td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
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
                        'September',
                        'Oktober',
                        'November',
                        'Desember',
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'Jumlah',
                    ]" :is-empty="count($data) == 0" :is-sortable="false" :freeze-columns="['No', 'Nama']">
                        @foreach ($data as $key => $d)
                            <tr>
                                <td class="sticky-col first-col">{{ $key + 1 }}</td>
                                <td class="sticky-col second-col">{{ $d->name }}</td>
                                @php
                                    $absenceData = $getStudentByAbsence($d->id);
                                    $sum = 0;
                                    $orderedAbsenceData = array_merge(
                                        array_slice($absenceData, 8, 4), // Sep - Dec
                                        array_slice($absenceData, 0, 8), // Jan - Aug
                                    );
                                @endphp
                                @foreach ($orderedAbsenceData as $absence)
                                    @php
                                        $sum += $absence;
                                    @endphp
                                    <td>{{ $absence }}</td>
                                @endforeach
                                <td>{{ $sum }}</td>
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
