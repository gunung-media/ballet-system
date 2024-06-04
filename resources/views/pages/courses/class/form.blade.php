@extends('layouts.app')
@section('title', 'Siswa Form')
@section('sidebar')
    <x-sidebar active-menu="Data Kelas" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Kelas']" />
@endsection
@section('content')
    <form class="row" action="{{ route('kelas.store') }}" method="POST">
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
                        <x-fields.input type="text" name="name" label="Nama Kelas" />
                        <hr />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Schedule</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="parent" id="parent">
                        <div class="row draggable" id="copy" style="background-color: #f8f9fa; border-radius:10px ">
                            <div class="col-12">
                                <x-fields.select name="schedule[0][day]" label="Hari" :choices="$days" />
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <x-fields.input type="time" name="schedule[0][time]" label="Waktu" />
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <x-fields.input type="number" name="schedule[0][duration]" label="Durasi" />
                            </div>
                            <button class="btn btn-danger" onclick="removeDiv(this)" type="button">-</button>
                            <button class="btn btn-primary add-btn" onclick="copyDiv()" type="button">+</button>
                        </div>
                        <hr />

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
        let counter = 0;

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
            button.closest('.row').remove();
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
