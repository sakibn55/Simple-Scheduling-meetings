@extends('app')
@section('title')
    {{ $data->name }}
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info">
                        <h3 class="text-white">Profile</h3>
                    </div>
                    <div class="card-body p-0">
                        @if ($data->image != null)
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('storage/' . $data->image->url) }}"
                                    alt="profile">
                            </div>
                        @else
                            <img class="img-fluid" src="{{ asset('img/sample.jpg') }}" alt="{{ $data->name }}">
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info">
                        <h3 class="text-white">
                            Profile Information</h3>
                    </div>
                    <div class="card-body">
                        <h3>{{ $data->name }}</h3>
                        <p>{{ $data->email }}</p>
                        <p>
                            {{ $data->phone }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
