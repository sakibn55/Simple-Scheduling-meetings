@extends('app')
@section('title') Available Time
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-center text-primary m-4">Add Available Times</h1>

                    <div class="card border-info">
                        <div class="card-body" id="reminderBook">
                            <div id="AdvisorCalendar"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/advisorCalender.js') }}"></script>
@endsection
