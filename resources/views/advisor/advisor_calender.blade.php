@extends('app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-center text-primary">Reminders</h1>

                    <div id="AdvisorCalendar"></div>

                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/advisorCalender.js') }}"></script>
@endsection
