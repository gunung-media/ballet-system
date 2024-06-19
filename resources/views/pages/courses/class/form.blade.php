@extends('layouts.app')
@section('title', 'Siswa Form')
@section('sidebar')
    <x-sidebar active-menu="Data Kelas" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Kelas']" />
@endsection
@section('content')
    <form class="row" action="{{ isset($data) ? route('kelas.update', $data->id) : route('kelas.store') }}" method="POST">

        @if (isset($data))
            @method('PUT')
        @endif

        @csrf
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Kelas</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.input type="text" name="name" label="Nama Kelas" :value="$data->name ?? null" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Jadwal</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="parent" id="parent">
                        @if (isset($data))
                            @foreach ($data->schedules as $key => $schedule)
                                <div class="row " id="copy" style="background-color: #f8f9fa; border-radius:10px ">
                                    <div class="col-12">
                                        <x-fields.select name="schedule[{{ $key }}][day]" label="Hari"
                                            :choices="$days" :value="$schedule->day" />
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <x-fields.input type="time" name="schedule[{{ $key }}][time]"
                                            label="Waktu" :value="$schedule->time" />
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <x-fields.input type="number" name="schedule[{{ $key }}][duration]"
                                            label="Durasi (Menit)" :value="$schedule->duration" />
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-danger w-100" onclick="removeDiv(this)"
                                                type="button">Hapus
                                                Jadwal</button>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-success add-btn w-100" onclick="copyDiv()"
                                                type="button">Tambah Jadwal</button>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                            @endforeach
                        @else
                            <div class="row " id="copy" style="background-color: #f8f9fa; border-radius:10px ">
                                <div class="col-12">
                                    <x-fields.select name="schedule[0][day]" label="Hari" :choices="$days" />
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <x-fields.input type="time" name="schedule[0][time]" label="Waktu" />
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <x-fields.input type="number" name="schedule[0][duration]" label="Durasi" />
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-danger w-100" onclick="removeDiv(this)" type="button">Hapus
                                            Jadwal</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-success add-btn w-100" onclick="copyDiv()"
                                            type="button">Tambah Jadwal</button>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        @endif

                    </div>
                    <div class="form-group">
                        <a class="btn btn-warning" href="{{ route('kelas.index') }}">Kembali</a>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('customStyles')
    <style>
        .draggable {
            cursor: move;
        }
    </style>
@endsection

@section('customScripts')
    <script>
        $(function() {
            $(".draggable").draggable({
                containment: ".parent",
                revert: true,
                cursor: "move",
            });
        });
    </script>

    <script>
        let counter = {{ isset($data) ? count($data->schedules) : 0 }}

        //TODO: only 1 day on schedule allowed

        function copyDiv() {
            const originalDiv = document.getElementById('copy');
            const clone = originalDiv.cloneNode(true);

            clone.id = 'copy' + counter;
            counter++;

            const inputs = clone.querySelectorAll('[name]');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                const newName = name.replace(/\[\d+\]/, '[' + counter + ']');
                input.setAttribute('name', newName);
            });
            document.getElementById('parent').appendChild(clone);

            updateAddButtonVisibility()
        }

        function removeDiv(button) {
            let firstRow = button.closest('.row');
            //FIX: this is not working
            if (firstRow) {
                let secondRow = firstRow.nextElementSibling;
                firstRow.remove();
                if (secondRow && secondRow.classList.contains('row')) {
                    secondRow.remove();
                }
            }
            updateAddButtonVisibility()
        }

        function updateAddButtonVisibility() {
            const parent = document.getElementById('parent');
            const rows = parent.getElementsByClassName('draggable');
            for (let i = 0; i < rows.length; i++) {
                const addButton = rows[i].getElementsByClassName('add-btn')[0];
                if (addButton) {
                    addButton.style.display = (i === rows.length - 1) ? 'inline-block' : 'none';
                }
            }
        }
    </script>
@endsection
