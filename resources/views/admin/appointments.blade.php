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
                            <table id="example" class="table display" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Advisor</th>
                                        <th>Student</th>
                                        <th>Confirmed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reminders as $index => $reminder)

                                        <tr>
                                            <td>{{ $index + 1 }}</td>
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
@section('script')
<script>
$(document).ready(function() {
    $('#example').DataTable();
});
</script>
@endsection
