@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">
                                    Hari
                                </p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ Carbon\Carbon::now()->format('l, d F Y H:i:s') }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        @if (!is_null($dataToCheck?->check_in))
                            <h5>Checkin: {{ $dataToCheck->check_in }}</h5>
                        @endif
                        <form method="POST" action="{{ route('employee.absence.checkin') }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100"
                                {{ is_null($dataToCheck?->check_in) ?: 'disabled' }}>Check In</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        @if (!is_null($dataToCheck?->check_out))
                            <h5>Checkout: {{ $dataToCheck->check_out }}</h5>
                        @endif
                        <form method="POST" action="{{ route('employee.absence.checkout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg w-100"
                                {{ is_null($dataToCheck?->check_out) ?: 'disabled' }}>Check Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
@endsection
