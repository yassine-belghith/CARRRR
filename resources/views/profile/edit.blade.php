@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Profile</h1>

    <div class="card mb-4">
        <div class="card-header">
            Update Profile Information
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="email">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Delete Account
        </div>
        <div class="card-body">
            <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
            </form>
        </div>
    </div>
</div>
@endsection
