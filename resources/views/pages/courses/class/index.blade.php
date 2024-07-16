@extends('layouts.app')
@section('title', 'Siswa')
@section('sidebar')
    <x-sidebar active-menu="Data Kelas" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Data Kelas']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Kelas</h6>
                        <p class="font-weight-light text-xs">Berikut data kelas yang ada di Sistem</p>
                    </div>

                    <div>
                        <a class="btn btn-primary" href="{{ route('kelas.create') }}">+ Tambah Data</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-table :table-columns="['No', 'Nama Kelas', 'Biaya', 'Jadwal']" :isEmpty="count($data) == 0">
                        @foreach ($data as $key => $d)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $d->name }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ IntegerUtils::toRupiah($d->price) }}</p>
                                </td>
                                <td class="">
                                    <p class="text-xs font-weight-bold mb-0">
                                        {!! $d->schedules->map(fn($schedule) => "{$schedule->day->value} {$schedule->time}")->join('<br>') !!}
                                    </p>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('kelas.edit', $d->id) }}"
                                        class="btn text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                        data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <a href="{{ route('kelas.show', $d->id) }}"
                                        class="btn text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                        data-original-title="Detail user">
                                        Detail
                                    </a>
                                    <form action="{{ route('kelas.destroy', $d->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="px-3 text-danger font-weight-bold text-xs btn" data-toggle="tooltip"
                                            data-original-title="Edit user">
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
    </div>
@endsection

@section('customScripts')
@endsection
