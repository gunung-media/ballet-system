@extends('layouts.app')
@section('title', 'Pegawai')
@section('sidebar')
    <x-sidebar active-menu="Data Pegawai" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Pegawai']" />
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
                            <i class="ni ni-laptop text-sm me-2"></i> Rekap
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
                                <h6>Data Pegawai</h6>
                                <p class="font-weight-light text-xs">Berikut data siswa yang ada di Sistem</p>
                            </div>

                            <div>
                                <a class="btn btn-primary" href="{{ route('guru.create') }}">+ Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <x-table :table-columns="['No', 'Nama', 'NIK', 'Tipe', 'Status']">
                                @foreach ($data as $key => $d)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset('storage/' . $d->photo) }}"
                                                        class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $d->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $d->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $d->identity_number }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $d->type->value }}</p>
                                        </td>
                                        <td class="align-middle  text-sm">
                                            <span
                                                class="badge badge-sm badge-{{ $d->status?->color() ?? 'success' }}">{{ $d->status?->value ?? 'Active' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('guru.edit', $d->id) }}"
                                                class="text-secondary font-weight-bold text-xs btn" data-toggle="tooltip"
                                                data-original-title="Edit user">
                                                Edit
                                            </a>
                                            <form action="{{ route('guru.destroy', $d->id) }}" method="post">
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
                                <h6>Rekap Absensi</h6>
                                <p class="font-weight-light text-xs">Rekap Absensi Pegawai</p>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <x-table :table-columns="['Tanggal', 'Nama', 'Check-in', 'Check-out']" id="rekap" :has-actions="false">
                                @foreach ($absences as $key => $absence)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ DateUtils::format($absence->date) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $absence->teacher->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $absence->check_in }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $absence->check_out }}
                                            </p>
                                        </td>
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
