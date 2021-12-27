@extends('app')
@section('title') Adivsors @endsection
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
                            <table class="table table-sm">
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
