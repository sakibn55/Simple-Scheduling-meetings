@extends('app')
@section('title')
    Admin
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card border-info mt-5">
                    <div class="card-header bg-info text-white">
                        <h3>
                            Add An Advisor
                        </h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.advisor.add') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="eamil">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="eamil">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    placeholder="Enter phone number" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="Enter password again" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Advisor</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
