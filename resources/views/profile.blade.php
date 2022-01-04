@extends('app')
@section('title')
    {{ auth()->user()->name }}
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-info mb-4">
                    <div class="card-header bg-info">
                        <h3 class="text-white">
                            Profile
                        </h3>
                    </div>
                    <div class="card-body p-0 ">
                        @if (auth()->user()->image != null)
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('storage/' . auth()->user()->image->url) }}"
                                    alt="profile">
                            </div>
                        @else
                            <p class="text-primary p-5">
                                Please Upload your Profile Image
                            </p>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info">
                        <h3 class="text-white">Update Your Profile Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <form action="profile" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ auth()->user()->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="title">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ auth()->user()->phone }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlFile1">Profile Image Upload</label>
                                    <input type="file" class="form-control-file" name="image" id="exampleFormControlFile1">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>

                        <div class="col text-right">
                            <h3>Delete Your Account</h3>
                            <form action="{{ route('account.destroy') }}" method="POST"
                                onsubmit="return confirm('Do you really want to Delete your Account?');">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Enter Password" required>
                                </div>
                                <button class="btn btn-warning">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
