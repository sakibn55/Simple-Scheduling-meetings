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
                        <h3>List of Students</h3>
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
                                    @foreach ($students as $index => $student)

                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $student->name }}</td>
                                            <td><a href="/profile/{{ $student->email }}">{{ $student->email }}</a></td>
                                            <td>
                                                <form action="{{ route('admin.user.destroy') }}" method="POST"
                                                    onsubmit="return confirm('Do you really want to Delete this User?');">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{ $student->email }}">
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
