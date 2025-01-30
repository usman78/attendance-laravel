@extends('app')
@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Dashboard</h2>
        <div class="row justify-content-center" style="margin-bottom: 20px;">
            <div class="col-md-6"> 
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome to the Dashboard</h5>
                        <p class="card-text">You are logged in as <span class="user-style">{{ Auth::user()->name }}</span></p>
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