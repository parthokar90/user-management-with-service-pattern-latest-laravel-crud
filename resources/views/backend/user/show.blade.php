@extends('backend.layouts.app')

@section('title', 'User Details')


@section('content')
    <div class="container-fluid card">
        <h1>User Details</h1>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <div class="form-group">
                <label for="current_avatar">Current Avatar</label>
                <br>
                @if($user->avatar)
                    <img src="{{ asset('backend/avatar/'.$user->avatar) }}" alt="Current Avatar" class="img-thumbnail" width="150">
                @else
                    <span>No avatar found</span>
                @endif
            </div>
    </div>
@endsection


