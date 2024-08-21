@extends('layouts.app')
@section('title', 'Pembayaran Reguler')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran Reguler" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Pembayaran Reguler']" />
@endsection
@section('content')
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
                            <x-table :table-columns="['No', 'Jenis', 'Jumlah']">
                                @foreach ($data as $key => $d)
                                    <tr>
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
@endsection
