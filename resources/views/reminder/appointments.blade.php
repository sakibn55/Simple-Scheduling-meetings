@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Location details</th>
                            <th scope="col">Lattitude </th>
                            <th scope="col">Longitude</th>
                            <th scope="col">Range</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Confirmed</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($reminders as $index=>$reminder)

                          <tr>
                            <th scope="row">{{$index+1}}</th>
                            <td>{{$reminder->title}}</td>
                            <td>{{$reminder->description}}</td>
                            <td>{{$reminder->location_title}}</td>
                            <td>{{$reminder->lattitude}}</td>
                            <td>{{$reminder->longitude}}</td>
                            <td>{{$reminder->range}}</td>
                            <td>{{$reminder->start}}</td>
                            <td>{{$reminder->end}}</td>
                            <td>@if ($reminder->status)
                                <button class=" btn btn-success">
                                    Confirmed
                                </button>
                                @else
                                <button class=" btn btn-danger">
                                    Not Confirmed
                                </button>
                            @endif</td>
                            <td>
                                <form action="{{route('reminder.destroy', $reminder)}}" method="POST"onsubmit="return confirm('Do you really want to Delete this Appointment?');">
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
@endsection
