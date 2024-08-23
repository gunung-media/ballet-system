@extends('layouts.simple')
@section('title', 'Presensi Form')
@section('content')
    <center>
        <h1>Data Kelas</h1>
    </center>
    <div class="row">
        @php
            function getInitials($name)
            {
                // Split the string by spaces to get individual words
                $words = explode(' ', $name);

                // Get the first character of each word and concatenate them
                $initials = '';
                foreach ($words as $word) {
                    $initials .= strtoupper($word[0]); // Convert to uppercase
                }

                // Return only the first two initials
                return substr($initials, 0, 2);
            }
        @endphp
        @foreach ($data as $d)
            <div class="col-md-4 col-12">
                @csrf
                <div class="card">
                    <div class="card-body p-2">
                        <div class="container-center">
                            <div id="profile-picture">{{ getInitials($d->name) }}</div>
                        </div>
                        <p class="card-title d-block text-darker text-center h5 pt-3">
                            {{ $d->name }}
                        </p>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('absen', $d->id) }}" name="state" value="Hadir"
                                    class="btn btn-primary w-100 btn-tooltip">
                                    <span class="btn-inner--icon"><i class="ni ni-user-run"></i></span>
                                    <span class="btn-inner--text">Pergi</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('customStyles')
    <style>
        .img-custom {
            max-width: 500px;
            max-height: 250px;
        }

        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #profile-picture {
            width: 100px;
            height: 100px;
            background-color: #007bff;
            color: #fff;
            font-size: 36px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            text-transform: uppercase;
        }
    </style>
@endsection
