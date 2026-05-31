@extends('app')

@section('title', 'User Dashboard')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Welcome, {{ Auth::user()->name }}!</h2>
            
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h5>Your Account Information</h5>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Mobile:</strong> {{ Auth::user()->mobile ?? 'Not provided' }}</p>
                    
                    <hr>
                    
                    <a href="#" class="btn btn-primary">My Bookings</a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Edit Profile</a>
                    
                    <form action="{{ route('customers.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection