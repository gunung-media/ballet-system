@extends('layouts.app')
@section('title', 'Staf')
@section('sidebar')
    <x-sidebar active-menu="Data Staf" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Data Staf']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Staf</h6>
                        <p class="font-weight-light text-xs">Berikut data pegawai yang ada di Sistem</p>
                    </div>

                    <div>
                        <a class="btn btn-primary" href="{{ route('pegawai.create') }}">+ Tambah Data</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-table :table-columns="['No', 'Nama', 'Gender']">
                        @foreach ($data as $key => $d)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('storage/' . $d->photo) }}" class="avatar avatar-sm me-3"
                                                alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $d->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $d->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $d->gender }}</p>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('pegawai.edit', $d->id) }}"
                                        class="text-secondary font-weight-bold text-xs btn" data-toggle="tooltip"
                                        data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <form action="{{ route('pegawai.destroy', $d->id) }}" method="post">
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
