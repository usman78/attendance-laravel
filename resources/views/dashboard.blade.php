@extends('app')
@push('styles')
    <style>
        body {
            background: darkgrey;
        }
        .card-body.modules {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center; /* This is not needed anymore */
            background: #294a70;
            color: #fff;
            border-radius: 5px;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5);
        }
        .card {
            /* padding: 10px; */
            background: #f3f3f3;
            margin-bottom: 10px;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center; /* This is not needed anymore */
            margin-top: 5px;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        button {
            background: #294a70 !important;
            border: 1px solid #fff !important;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5);
        }

    </style>
    
@endpush
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center" style="margin-bottom: 20px;">
            <div class="col-md-6"> 
                <div class="card">
                    <div class="card-body" style="padding: 10px;">
                        <div class="card">
                            <div class="card-body modules">
                                <h5 class="card-title">Dashboard</h5>
                                <p class="card-text">Logged in as: <span class="user-style">{{ Auth::user()->name }}</span></p>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('attendance') }}">
                                    <div class="card card-modules">
                                        <div class="card-body modules">
                                            <h5 class="card-title">Mark Attendance</h5>
                                            {{-- <p class="card-text">Mark your attendance by capturing your face.</p> --}}
                                            <img src="{{ asset('user-w.png') }}" style="max-width: 125px;" class="img-fluid" alt="Attendance">
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <a href="{{ route('enroll') }}">
                                    <div class="card">
                                        <div class="card-body modules">
                                            <h5 class="card-title">Enroll Face</h5>
                                            {{-- <p class="card-text">Enroll your face for attendance marking.</p> --}}
                                            <img src="{{ asset('face-id-w.png') }}" style="max-width: 125px;" class="img-fluid" alt="Enroll">
                                        </div>
                                    </div>    
                                </a>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </form>
                    </div>  
                </div>      
            </div>
        </div>
    </div>
@endsection