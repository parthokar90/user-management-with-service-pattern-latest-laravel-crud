@extends('backend.layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid card">
        <h4>Edit User</h4>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="current_avatar">Current Avatar</label>
                <br>
                @if($user->avatar)
                    <img src="{{ asset('backend/avatar/'.$user->avatar) }}" alt="Current Avatar" class="img-thumbnail" width="150">
                @else
                    <span>No avatar found</span>
                @endif
            </div>
            <div class="form-group">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" class="form-control-file" id="avatar">
                @error('avatar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <span>Minimum 8 Char Long</span>
                <input type="password" name="password" class="form-control" id="password">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 mb-3">Update</button>
        </form>
    </div>
@endsection

