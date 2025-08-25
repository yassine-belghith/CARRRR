@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <h1>Locations</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('dashboard.locations.create') }}" class="btn btn-primary mb-3">Create New Location</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>City</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->city }}</td>
                    <td>{{ $location->country }}</td>
                    <td>
                        <a href="{{ route('dashboard.locations.show', $location) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('dashboard.locations.manageDrivers', $location->id) }}" class="btn btn-sm btn-info">Manage Drivers</a>
                        <a href="{{ route('dashboard.locations.edit', $location->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dashboard.locations.destroy', $location->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
