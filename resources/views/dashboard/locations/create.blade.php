@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <h1>Create New Location</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.locations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}" required>
        </div>
        <div class="mb-3">
            <label for="postal_code" class="form-label">Postal Code</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="opening_hours_weekdays" class="form-label">Opening Hours (Weekdays)</label>
            <input type="time" class="form-control" id="opening_hours_weekdays" name="opening_hours_weekdays" value="{{ old('opening_hours_weekdays') }}" required>
        </div>
        <div class="mb-3">
            <label for="closing_hours_weekdays" class="form-label">Closing Hours (Weekdays)</label>
            <input type="time" class="form-control" id="closing_hours_weekdays" name="closing_hours_weekdays" value="{{ old('closing_hours_weekdays') }}" required>
        </div>
        <div class="mb-3">
            <label for="opening_hours_weekends" class="form-label">Opening Hours (Weekends)</label>
            <input type="time" class="form-control" id="opening_hours_weekends" name="opening_hours_weekends" value="{{ old('opening_hours_weekends') }}">
        </div>
        <div class="mb-3">
            <label for="closing_hours_weekends" class="form-label">Closing Hours (Weekends)</label>
            <input type="time" class="form-control" id="closing_hours_weekends" name="closing_hours_weekends" value="{{ old('closing_hours_weekends') }}">
        </div>
        <button type="submit" class="btn btn-primary">Create Location</button>
    </form>
</div>
@endsection
