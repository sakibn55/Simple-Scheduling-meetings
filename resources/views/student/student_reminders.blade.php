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
                            <th scope="col">Location title</th>
                            <th scope="col">Lattitude</th>
                            <th scope="col">Longitude</th>

                            <th scope="col">Start</th>

                            <th scope="col">End</th>
                            <th scope="col">Advisor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($reminders as $index=>$item)

                          <tr>
                            <th scope="row">{{$index+1}}</th>
                            <td>{{$item->title}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->location_title}}</td>
                            <td>{{$item->lattitude}}</td><td>{{$item->longitude}}</td><td>{{$item->start}}</td><td>{{$item->end}}</td>
                            <td>
                                {{$item->advisor->name}}
                            </td>
                            <td>
                                @if($item->status)
                                    <button class="btn btn-success">Confirmed</button>
                                    @else
                                    <button class="btn btn-info">Not Confirmed</button>
                                @endif
                            </td>
                            <td>
                                <form action="{{route('reminder.destroy', $item)}}" method="POST"onsubmit="return confirm('Do you really want to Delete this Appointment?');">
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