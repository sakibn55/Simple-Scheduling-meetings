@extends('app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{route("admin.counselor.add")}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                </div>

                <div class="form-group">
                  <label for="eamil">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter password again" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Counselor</button>

            </form>
        </div>
    </div>
</div>
@endsection
