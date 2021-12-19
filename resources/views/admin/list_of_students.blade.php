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
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($students as $index=>$student)

                          <tr>
                            <th scope="row">{{$index+1}}</th>
                            <td>{{$student->name}}</td>
                            <td>{{$student->email}}</td>
                            <td>
                                <form action="{{route('admin.user.destroy')}}" method="POST"onsubmit="return confirm('Do you really want to Delete this Counselor?');">
                                    @csrf
                                    <input type="hidden" name="email" value="{{$student->email}}">
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
