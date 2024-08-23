@extends('layouts.app')
@section('title', 'Pembayaran Event')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran Event" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Data Pembayaran Event']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Data Pembayaran Event</h6>
                        <p class="font-weight-light text-xs">Berikut data yang ada di Sistem</p>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="{{ route('installment.create') }}">+ Tambah Data</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-table :table-columns="['No', 'Title', 'Jumlah']">
                        @foreach ($data as $key => $d)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $d->title }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ IntegerUtils::toRupiah($d->total) }}</p>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('installment.edit', $d->id) }}"
                                        class="text-secondary font-weight-bold text-xs btn" data-toggle="tooltip"
                                        data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <br />
                                    <a href="{{ route('installment.show', $d->id) }}"
                                        class=" font-weight-bold text-xs btn btn-warning" data-toggle="tooltip"
                                        data-original-title="Edit user" target="_blank">
                                        Cetak
                                    </a>
                                    <form action="{{ route('installment.destroy', $d->id) }}" method="post">
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
