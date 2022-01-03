@extends('app')
@section('title') {{auth()->user()->name}} @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 m-auto">
                <div class="card border-info mt-5 mr-auto ml-auto">
                    <div class="card-header bg-info">
                        <h2>Select an Advisor to make an Appointment</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table display" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <form action="/reminder" class="form-inline mb-2" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="advisor_email" value="{{ $item->email }}">
                                                    <button type="submit" class="btn btn-primary">Make an
                                                        Appointment</button>
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
