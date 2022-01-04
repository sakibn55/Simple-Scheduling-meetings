@extends('app')
@section('title')
    Admin
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card boder-info mt-5">
                    <div class="card-header bg-info text-white">
                        <h3>List of Advisors</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($advisor as $index => $data)

                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $data->name }}</td>
                                            <td>
                                                <a href="/profile/{{ $data->email }}">{{ $data->email }}</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.user.destroy') }}" method="POST"
                                                    onsubmit="return confirm('Do you really want to Delete this User?');">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{ $data->email }}">
                                                    <button class="btn btn-warning">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
