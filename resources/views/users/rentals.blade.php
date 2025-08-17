@extends('layouts.app')

@section('content')
    @if($locations->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">My Locations</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Postal Code</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->address }}</td>
                                    <td>{{ $location->city }}</td>
                                    <td>{{ $location->country }}</td>
                                    <td>{{ $location->postal_code }}</td>
                                    <td>{{ $location->phone }}</td>
                                    <td>{{ $location->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Mes Locations</h4>
                </div>
                <div class="card-body">
                    @if($rentals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Voiture</th>
                                        <th>Date de début</th>
                                        <th>Date de fin</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rentals as $rental)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($rental->car)
                                                    {{ $rental->car->brand }} {{ $rental->car->model }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ optional($rental->start_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                            <td>{{ optional($rental->end_date)->format('d/m/Y') ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($rental->status === 'completed') bg-success
                                                    @elseif($rental->status === 'cancelled') bg-danger
                                                    @else bg-primary
                                                    @endif">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $rentals->links() }}
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            Vous n'avez effectué aucune location pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
