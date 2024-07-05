@extends('layouts.app')
@section('title', 'Presensi Pegawai')
@section('sidebar')
    <x-sidebar active-menu="Absensi Pegawai" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Absensi Pegawai']" />
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#pill-absensi" role="tab"
                            aria-controls="preview" aria-selected="true">
                            <i class="ni ni-badge text-sm me-2"></i> Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#pill-rekap" role="tab"
                            aria-controls="code" aria-selected="false">
                            <i class="ni ni-laptop text-sm me-2"></i> Rekap
                        </a>
                    </li>
                </ul>
            </div>
            <br />
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pill-absensi" role="tabpanel"
                    aria-labelledby="pills-absensi-tab">

                    <div class="card card-calendar">
                        <div class="card-body p-3">
                            <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                            <p class="font-weighr-light text-xs">*Klik Kelas Untuk Melanjutkan Presensi</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pill-rekap" role="tabpanel" aria-labelledby="pill-rekap-tab">
                    <div class="card">
                        <div class="card-body px-0 pt-0 pb-2">
                            <x-table :table-columns="['No', 'Tanggal', 'Jumlah Hadir', 'Jumlah Tidak Hadir']">

                                @foreach ($absences as $key => $absence)
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ Carbon\Carbon::parse($absence->date)->format('d F y') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $absence->total }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $employeeCount - $absence->total }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('pegawai.absence.form', ['date' => $absence->date]) }}"
                                            class="text-secondary font-weight-bold text-xs btn w-100" data-toggle="tooltip">
                                            Detail
                                        </a>
                                    </td>
                                @endforeach
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                selectable: false,
                editable: false,
                initialDate: '{{ now() }}',
                events: @json($datas),
                eventClick: function(info) {
                    const eventId = info.event.id;
                    const date = info.event.start;
                    const jsDate = new Date(date);

                    const year = jsDate.getFullYear();
                    const month = String(jsDate.getMonth() + 1).padStart(2, '0');
                    const day = String(jsDate.getDate()).padStart(2, '0');
                    const hours = String(jsDate.getHours()).padStart(2, '0');
                    const minutes = String(jsDate.getMinutes()).padStart(2, '0');

                    const phpDateString = `${year}-${month}-${day}`;

                    window.location.href =
                        `{{ route('pegawai.absence.form') }}?id=${eventId}&date=${phpDateString}`;
                },
                views: {
                    month: {
                        titleFormat: {
                            month: "long",
                            year: "numeric"
                        }
                    },
                    agendaWeek: {
                        titleFormat: {
                            month: "long",
                            year: "numeric",
                            day: "numeric"
                        }
                    },
                    agendaDay: {
                        titleFormat: {
                            month: "short",
                            year: "numeric",
                            day: "numeric"
                        }
                    }
                },
            });
            calendar.render();
        })
    </script>
@endsection
