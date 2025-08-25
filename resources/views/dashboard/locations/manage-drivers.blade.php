@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <h1>Manage Drivers for {{ $location->name }}</h1>

    <form action="{{ route('dashboard.locations.updateDrivers', $location) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="drivers">Assign Drivers</label>
            <select name="drivers[]" id="drivers" class="form-control" multiple>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ in_array($driver->id, $assignedDriverIds) ? 'selected' : '' }}>
                        {{ $driver->name }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold down the Ctrl (windows) or Command (Mac) button to select multiple options.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Drivers</button>
        <a href="{{ route('dashboard.locations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
