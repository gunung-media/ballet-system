@extends('layouts.app')
@section('title', 'Pembayaran Reguler')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran Reguler" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Pembayaran Reguler']" />
@endsection
@section('content')

    <div id="floating-button" style="display:none; position:fixed; bottom:20px; right:20px;z-index:100">
        <button class="btn btn-primary" onclick="printSelected()">Cetak</button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#pill-absensi" role="tab"
                            aria-controls="preview" aria-selected="true">
                            <i class="ni ni-badge text-sm me-2"></i> Tabel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#pill-rekap" role="tab"
                            aria-controls="code" aria-selected="false">
                            <i class="ni ni-laptop text-sm me-2"></i> Rekap SPP
                        </a>
                    </li>
                </ul>
            </div>
            <br />
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pill-absensi" role="tabpanel"
                    aria-labelledby="pills-absensi-tab">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <div>
                                <h6>Pembayaran Reguler</h6>
                                <p class="font-weight-light text-xs">Berikut data pembayaran yang ada di Sistem</p>
                            </div>

                            <div>
                                <a class="btn btn-primary" href="{{ route('spp.create') }}">+ Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <x-table :table-columns="['No', 'Jenis', 'Jumlah']" :is-selectable="true">
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td><input type="checkbox" class="item-checkbox" value="{{ $d->id }}" /></td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $d->tuition_type->value }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ IntegerUtils::toRupiah($d->amount) }}
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('spp.edit', $d->id) }}"
                                                class="text-secondary font-weight-bold text-xs btn" data-toggle="tooltip"
                                                data-original-title="Edit user">
                                                Edit
                                            </a>
                                            <br />
                                            <a href="{{ route('spp.cetak-spp', ['id' => $d->id]) }}"
                                                class=" font-weight-bold text-xs btn btn-warning" data-toggle="tooltip"
                                                data-original-title="Edit user" target="_blank">
                                                Cetak
                                            </a>
                                            <form action="{{ route('spp.destroy', $d->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="px-3 text-danger font-weight-bold text-xs btn"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pill-rekap" role="tabpanel" aria-labelledby="pill-rekap-tab">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between">
                            <div>
                                <h6>Pembayaran SPP</h6>
                                <p class="font-weight-light text-xs">Berikut data pembayaran yang ada di Sistem</p>
                            </div>

                            <div>
                                <!-- <x-fields.select name="month" label="Pilih Bulan" :choices="$month" :value="$defaultMonth" -->
                                <!--     :is-required="true" /> -->
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <x-table :table-columns="$tableHeaders" id="rekap" :has-actions="false">
                                @foreach ($dataSpp as $key => $d)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ DateUtils::format($d->for_month) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $d->student?->name ?? $d->student_name }}
                                            </p>
                                        </td>
                                        @foreach ($classes as $classIdx => $class)
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $d->class_id === $class->id ? IntegerUtils::toRupiah($d->amount) : 0 }}
                                                    {{ $d->class_id === $class->id  && !is_null($d->discount) ? "\nDiskon: {$d->discount}%\n" . IntegerUtils::toRupiah($d->amount - ($d->amount * ($d->discount / 100)))  : '' }}

                                                </p>
                                            </td>
                                        @endforeach
                                    </tr>
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
        function printSelected() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            if (selectedIds.length > 0) {
                const printUrl = `{{ route('spp.cetak-spp') }}?id=${selectedIds.join(',')}`;
                window.open(printUrl, '_blank');
            }
        };
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const floatingButton = document.getElementById('floating-button');
            const selectAllCheckbox = document.getElementById('select-all');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateFloatingButton);
            });

            selectAllCheckbox.addEventListener('change', function() {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateFloatingButton();
            });

            function updateFloatingButton() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                floatingButton.style.display = anyChecked ? 'block' : 'none';
            }
        });
    </script>
@endsection
