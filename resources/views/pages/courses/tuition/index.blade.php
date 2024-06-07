@extends('layouts.app')
@section('title', 'Pembayaran SPP')
@section('sidebar')
    <x-sidebar active-menu="Pembayaran SPP" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Kursus', 'Pembayaran SPP']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div>
                        <h6>Pembayaran SPP</h6>
                        <p class="font-weight-light text-xs">Berikut data pembayaran yang ada di Sistem</p>
                    </div>

                    <div>
                        <a class="btn btn-primary" href="{{ route('spp.create') }}">+ Tambah Data</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-table :table-columns="['No', 'Nama Siswa', 'Bulan', 'Jumlah']">
                        @foreach ($data as $key => $d)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $d->student->name }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $d->for_month }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">Rp. {{ number_format($d->amount, 0, ',') }}</p>
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
