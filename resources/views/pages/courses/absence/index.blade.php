@extends('layouts.app')
@section('title', 'Presensi')
@section('sidebar')
    <x-sidebar active-menu="Data Absensi" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Absensi']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-calendar">
                <div class="card-body p-3">
                    <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
                    <p class="font-weighr-light text-xs">*Klik Kelas Untuk Melanjutkan Presensi</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script>
        var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
            initialView: "dayGridMonth",
            headerToolbar: {
                start: 'title', // will normally be on the left. if RTL, will be on the right
                center: '',
                end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
            },
            selectable: true,
            editable: true,
            initialDate: '{{ now() }}',
            events: @json($events),
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
                alert('ID: ' + info.event.id);
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
    </script>
@endsection
