@extends('app')
@push('styles')
    <style>
        .login-button {
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
    
@endpush
@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>
        <div class="row justify-content-center" style="margin-bottom: 20px;">
            <div class="col-md-6"> 
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email Address:</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Your Email" required>  
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Your Password" required>
                            </div>
                            <div class="form-group login-button">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            @error('email')
                                <div class="feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </form> 
                    </div>
                </div>  
            </div>
        </div>
    </div>
@endsection    