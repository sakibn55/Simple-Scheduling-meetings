@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mt-5 mr-auto ml-auto">
                    <div class="card-body">
                        <h5 class="card-title">Advisors</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Advisor</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)

                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $item->name }}</td>
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
