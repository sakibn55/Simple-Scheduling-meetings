@extends('app')
@section('title')
    Appointments
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card border-info mt-5">
                    <div class="card-header bg-info text-white">
                        <h3>List of appointments</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Advisor</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">Confirmed</th>
                                        <th scope="col" colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reminders as $index => $reminder)

                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $reminder->title }}</td>
                                            <td>
                                                <a
                                                    href="/profile/{{ $reminder->advisor->email }}">{{ $reminder->advisor->name }}</a>
                                            </td>
                                            <td>
                                                <a
                                                    href="/profile/{{ $reminder->student->email }}">{{ $reminder->student->name }}</a>
                                            </td>

                                            <td>
                                                @if ($reminder->status)
                                                    <button class=" btn btn-success">
                                                        Confirmed
                                                    </button>
                                                @else
                                                    <button class=" btn btn-danger">
                                                        Not Confirmed
                                                    </button>
                                                @endif
                                            </td>
                                            <td><a href="/admin/appointment/{{ $reminder->slug }}"
                                                    class="btn btn-info">View</a>
                                            <td>
                                                <form action="{{ route('reminder.destroy', $reminder) }}" method="POST"
                                                    onsubmit="return confirm('Do you really want to Delete this Appointment?');">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
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
