@extends('app')
@section('title')
    Make An Appointment
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="text-center text-primary m-4">Make an Appointment</h1>
                </div>
                <form action="/reminder" class="form-inline mb-2" method="GET">
                    @csrf
                    <div class="col">
                        <select name="advisor_email" class="custom-select" id="advisor_email">
                            @foreach ($advisors as $item)
                                <option @if (request('advisor_email') == $item->email) selected @endif value="{{ $item->email }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>

            <div class="row">
                <div class="col">


                    <div id="calendar"></div>
                    <!-- Modal -->
                    @include('include.reminderAddModal')

                    @include('include.reminderUpdateModal')
                </div>
            </div>
        </div>
    </section>

    <script>
        var data = {!! $data !!};
    </script>
    <script src="{{ asset('js/studentCalender.js') }}"></script>
@endsection
