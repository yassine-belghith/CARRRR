@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Modifier la Location #{{ $rental->id }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.rentals.update', $rental->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('dashboard.rentals._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
