@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nouvelle Location</h4>
                    <a href="{{ route('dashboard.rentals.index') }}" class="btn btn-secondary btn-sm float-right">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.rentals.store') }}" method="POST">
                        @include('dashboard.rentals._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
