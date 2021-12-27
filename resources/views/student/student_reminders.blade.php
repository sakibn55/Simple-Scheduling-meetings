@extends('app')
@section('title')
    My Appointments
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col mt-5 mr-auto ml-auto">
                <div class="card border-info">
                    <div class="card-header bg-info">
                        <h2 class="text-white">My Appointments</h2>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Advisor</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reminders as $index => $item)

                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $item->title }}</td>
                                            <td>
                                                <a
                                                    href="/profile/{{ $item->advisor->email }}">{{ $item->advisor->name }}</a>
                                            </td>
                                            <td>
                                                @if ($item->status)
                                                    <button class="btn btn-success">Confirmed</button>
                                                @else
                                                    <button class="btn btn-info">Not Confirmed</button>
                                                @endif
                                            </td>
                                            <td><a href="/appointment/{{ $item->slug }}" class="btn btn-info">View</a>
                                            </td>
                                            <td>

                                                <form action="{{ route('reminder.destroy', $item) }}" method="POST"
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
