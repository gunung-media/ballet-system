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
                                :value="$data->studio_type ?? null" />
                        </div>

                        <x-fields.input type="number" name="amount" label="Jumlah " :value="$data->amount ?? null"
                            :is-money="true" />

                        <x-fields.input type="textarea" name="note" label="Catatan " :value="$data->note ?? null"
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
                <div class="card-header pb-0">
                    <h6>Total</h6>
                </div>
                <div class="card-body">
                    <div action="">
                        <x-fields.select name="discount_type" label="Tipe Diskon" :choices="$discountTypes" :is-required="false"
                            :value="$data->discount_type ?? null" />

                        <x-fields.input type="number" name="discount" label="Diskon " :value="$data->discount ?? 0" :is-percentage="true"
                            hint-text="Maximal 100%" :is-required="false" />

                        <x-fields.input type="number" name="total" label="Jumlah" :is-required="false" :is-read-only="true"
                            :value="0" />

                        <x-fields.input type="number" name="discount-total" label="Diskon Total" :is-required="false"
                            :is-read-only="true" :value="0" />

                        <x-fields.input type="number" name="sum" label="Total" :is-required="false" :is-read-only="true"
                            :value="0" />
                    </div>

                </div>
            </div>
        </div>

    </form>
@endsection

@section('customScripts')
    <script>
        const handleSummarizer = () => {
            const inputMoneyAmount = document.querySelector('#money-amount');
            const inputDiscount = document.querySelector('#percentage-discount');
            const totalAmount = document.querySelector('input[name="total"]');
            const totalSum = document.querySelector('input[name="sum"]');
            const totalDiscount = document.querySelector('input[name="discount-total"]');
            const inputType = document.querySelector('select[name="tuition_type"]');

            function handleDiscount() {
                const totalAmountValue = parseInt(totalAmount?.value) || 0;
                const discountPercentage = parseInt(inputDiscount.value) || 0;

                const hack = inputType.value === 'Iuran Bulanan(SPP)' ? 1 : 1000
                const totalDiscountValue = (discountPercentage / 100) * totalAmountValue
                totalDiscount.value = totalDiscountValue * hack;
                totalSum.value = (totalAmountValue - totalDiscountValue) * hack
            }

            inputMoneyAmount.addEventListener('change', function() {
                totalAmount.value = inputMoneyAmount.value
                handleDiscount()
            })

            inputDiscount.addEventListener('change', handleDiscount)

        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var additionalInput = document.querySelector("#additional-input");
            const inputStudent = document.querySelector('select[name="student_id"]');
            const inputType = document.querySelector('select[name="tuition_type"]');
            const inputClass = document.querySelector('select[name="class_id"]');
            const inputForMonth = document.querySelector('input[name="for_month"]');
            const inputStudioType = document.querySelector('select[name="studio_type"]');
            const inputMoneyAmount = document.querySelector('#money-amount');
            const inputAmount = document.querySelector('input[name="amount"]');
            const sppBx = document.querySelector('#spp-input')
            const studioBx = document.querySelector('#studio-input')

            handleSummarizer()

            function updateUIBasedOnSelection() {
                additionalInput.style.display = inputStudent.value === 'Lainnya' ? "block" : "none";

                if (inputType.value === 'Iuran Bulanan(SPP)') {
                    sppBx.style.display = "block";
                    studioBx.style.display = "none";
                    inputStudent.required = true;
                    inputClass.required = true;
                    inputForMonth.required = true;
                    return;
                } else {
                    if (sppBx && inputStudent && inputClass && inputForMonth) {
                        sppBx.style.display = "none";
                        inputStudent.required = false;
                        inputClass.required = false;
                        inputForMonth.required = false;
                    }
                }

                if (inputType.value === 'Biaya Sewa Studio') {
                    studioBx.style.display = "block";
                    sppBx.style.display = "none";
                    inputStudioType.required = true;
                    return
                } else {
                    if (studioBx && inputStudioType) {
                        studioBx.style.display = "none";
                        inputStudioType.required = false;
                    }
                }
            }

            updateUIBasedOnSelection();

            inputType.addEventListener('change', updateUIBasedOnSelection);

            inputClass.addEventListener('change', function() {
                const dataCost = inputClass.options[inputClass.selectedIndex].getAttribute('data-cost');
                inputMoneyAmount.value = dataCost
                inputAmount.value = dataCost

                const inputDiscount = document.querySelector('#percentage-discount');
                const totalAmount = document.querySelector('input[name="total"]');
                const totalSum = document.querySelector('input[name="sum"]');
                const totalDiscount = document.querySelector('input[name="discount-total"]');

                function handleDiscount() {
                    const totalAmountValue = parseInt(totalAmount?.value) || 0;
                    const discountPercentage = parseInt(inputDiscount.value) || 0;

                    const totalDiscountValue = (discountPercentage / 100) * totalAmountValue
                    totalDiscount.value = totalDiscountValue;
                    totalSum.value = (totalAmountValue - totalDiscountValue);
                }

                totalAmount.value = dataCost
                handleDiscount()

            })

            inputStudent.addEventListener('change', function() {
                const value = inputStudent.value;

                if (value === "Lainnya") {
                    additionalInput.style.display = "block";
                    inputClass.innerHTML = '';
                    Object.entries(@json($defaultClasses)).forEach(function([id, name]) {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        inputClass.appendChild(option);
                    });
                    return
                }

                additionalInput.style.display = "none";
                fetch(`/get-classes/${value}`)
                    .then(response => response.json())
                    .then(data => {
                        inputClass.innerHTML = '';
                        const option = document.createElement('option');
                        option.value = null;
                        option.textContent = "Pilih";
                        inputClass.appendChild(option);
                        Object.entries(data).forEach(function([id, [name, cost]]) {
                            const option = document.createElement('option');
                            option.value = id;
                            option.textContent = name;
                            option.setAttribute('data-cost', cost)
                            inputClass.appendChild(option);
                        });
                    });
            });
        });
    </script>
@endsection
