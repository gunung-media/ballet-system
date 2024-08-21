@extends('layouts.app')
@section('title', 'SPP Form')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran Reguler" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Reguler']" />
@endsection
@section('content')
    <form class="row" enctype="multipart/form-data"
        action="{{ isset($data) ? route('spp.update', $data->id) : route('spp.store') }}" method="POST">

        @if (isset($data))
            @method('PUT')
        @endif

        @csrf
        <div class="col-md-8 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Form Pembayaran Reguler</h6>
                        <p class="font-weight-light text-xs">Wajib masukan data yang bertanda <span
                                class="text-danger">*</span></p>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.select name="tuition_type" label="Tipe" :choices="$tuitionTypes" :value="$data->tuition_type ?? null" />

                        <div id="spp-input" style="display: none;">
                            <x-fields.select name="student_id" label="Siswa" :choices="$students" :value="$data->student?->id ?? (isset($data->student_name) ? 'Lainnya' : null)"
                                :is-required="false" :is-tuition="true" :other-input="$data->student_name ?? null" />

                            <x-fields.select name="class_id" label="Pilih Kelas" :choices="$defaultClasses" :value="$data->class_id ?? null"
                                :is-required="false" />

                            <x-fields.input type="month" name="for_month" label="Untuk Bulan" :value="isset($data->for_month) ? substr($data->for_month, 0, 7) : null"
                                :is-required="false" />
                        </div>

                        <div id="studio-input" style="display:none">
                            <x-fields.select name="studio_type" label="Tipe Studio" :choices="$studioTypes" :is-required="false"
                                :value="$data->studio_type ?? null":is-required="false" />
                        </div>

                        <x-fields.input type="number" name="amount" label="Jumlah " :value="$data->amount ?? null"
                            :is-money="true" />

                        <x-fields.input type="textarea" name="notes" label="Catatan " :value="$data->notes ?? null"
                            :is-required='false' />

                    </div>

                    <div class="form-group">
                        <a class="btn btn-warning" href="{{ route('spp.index') }}">Kembali</a>
                        <button class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Total</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.select name="discount_type" label="Tipe Diskon" :choices="$discountTypes" :is-required="false"
                            :value="$data->discount_type ?? null" />

                        <x-fields.input type="number" name="discount" label="Diskon " :value="$data->discount ?? 0" :is-percentage="true"
                            hint-text="Maximal 100%" :is-required="false" />
                    </div>

                </div>
            </div>
        </div>

    </form>
@endsection

@section('customScripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedStudent = document.querySelector('select[name="student_id"]');
            const selectedType = document.querySelector('select[name="tuition_type"]');
            const classSelect = document.querySelector('select[name="class_id"]');
            const sppBx = document.querySelector('#spp-input')
            const studioBx = document.querySelector('#studio-input')
            var additionalInput = document.querySelector("#additional-input");
            const forMonthInput = document.querySelector('input[name="for_month"]');
            const studioTypeInput = document.querySelector('select[name="studio_type"]');

            if (selectedStudent.value === 'Lainnya') {
                additionalInput.style.display = "block";
            }

            if (selectedType.value === 'Iuran Bulanan(SPP)') {
                sppBx.style.display = "block";
                selectedStudent.required = true;
                classSelect.required = true;
                forMonthInput.required = true;
            }

            if (selectedType.value === 'Biaya Sewa Studio') {
                studioBx.style.display = "block";
                studioTypeInput.required = true;
            }
            selectedType.addEventListener('change', function() {
                const value = selectedType.value;
                if (value === 'Iuran Bulanan(SPP)') {
                    sppBx.style.display = "block";
                    studioBx.style.display = "none";
                    selectedStudent.required = true;
                    classSelect.required = true;
                    forMonthInput.required = true;
                } else {
                    selectedStudent.required = false;
                    classSelect.required = false;
                    forMonthInput.required = false;
                    sppBx.style.display = "none";
                }

                if (selectedType.value === 'Biaya Sewa Studio') {
                    studioBx.style.display = "block";
                    sppBx.style.display = "none";
                    studioTypeInput.required = true;
                } else {
                    studioTypeInput.required = false;
                    studioBx.style.display = "none";
                }
            })


            selectedStudent.addEventListener('change', function() {
                const value = selectedStudent.value;

                if (value === "Lainnya") {
                    additionalInput.style.display = "block";
                    classSelect.innerHTML = '';
                    Object.entries(@json($defaultClasses)).forEach(function([id, name]) {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        classSelect.appendChild(option);
                    });
                    return
                }
                additionalInput.style.display = "none";
                fetch(`/get-classes/${value}`)
                    .then(response => response.json())
                    .then(data => {
                        classSelect.innerHTML = '';
                        Object.entries(data).forEach(function([id, name]) {
                            const option = document.createElement('option');
                            option.value = id;
                            option.textContent = name;
                            classSelect.appendChild(option);
                        });
                    });
            });
        });
    </script>
@endsection
