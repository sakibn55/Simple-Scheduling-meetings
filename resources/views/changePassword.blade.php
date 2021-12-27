@extends('app')
@section('title')
    Change Password
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col-md-7 m-5">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <h3 class="card-title text-white">Change Password</h3>

                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ route('password.change') }}">
                            @csrf
                            <div class="card-body">
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                @endforeach
                                <div class="form-group row">

                                    <label for="password" class="col-sm-4 col-form-label">Current Password</label>

                                    <div class="col-sm-8">
                                        <input id="password" type="password" class="form-control" name="current_password"
                                            autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-4 col-form-label">New Password</label>

                                    <div class="col-sm-8">
                                        <input id="new_password" type="password" class="form-control" name="new_password"
                                            autocomplete="current-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-4 col-form-label">New Confirm Password</label>

                                    <div class="col-sm-8">
                                        <input id="new_confirm_password" type="password" class="form-control"
                                            name="new_confirm_password" autocomplete="current-password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info float-right mb-2">Change Password</button>
                            </div>
                            <!-- /.card-body -->

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
