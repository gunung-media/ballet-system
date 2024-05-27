@extends('layouts.app')
@section('title', 'Kategori')
@section('sidebar')
    <x-sidebar active-menu="Kategori" />
@endsection
@section('breadcrumb')
    <x-breadcrumb :stacks="['Home', 'Penjualan', 'Kategori']" />
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Kategori</h6>
                    <p class="font-weight-light text-xs">Berikut data kategori yang ada di Sistem</p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <x-table :table-columns="['No', 'Kategori']">
                        @foreach (range(1, 20) as $item)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $item }}</p>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">John Michael</h6>
                                            <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                        data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <a href="javascript:;" class="px-3 text-danger font-weight-bold text-xs"
                                        data-toggle="tooltip" data-original-title="Edit user">
                                        Hapus
                                    </a>
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
