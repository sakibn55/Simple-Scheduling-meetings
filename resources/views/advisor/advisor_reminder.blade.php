@extends('app')
@section('title') My Appointment @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card border-info mt-5">
                    <div class="card-header bg-info text-white">
                        <h3>My Appointments</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table display">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Student</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reminders as $index => $item)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $item->title }}</td>

                                            <td>

                                                <a
                                                    href="/profile/{{ $item->student->email }}">{{ $item->student->name }}</a>
                                            </td>
                                            <td>
                                                @if ($item->status)
                                                    <button class="btn btn-success">Confirmed</button>
                                                @else
                                                    <button class="btn btn-info">Not Confirmed</button>
                                                @endif
                                            </td>
                                            <td><a href="/advisor/appointment/{{ $item->slug }}"
                                                    class="btn btn-info">View</a>
                                                    <form action="/advisor/confirmation" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="slug" value="{{ $item->slug }}">
                                                    @if ($item->status)
                                                        <button class="btn btn-danger">Deny</button>
                                                    @else
                                                        <button class="btn btn-primary">Confirm</button>
                                                    @endif
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
