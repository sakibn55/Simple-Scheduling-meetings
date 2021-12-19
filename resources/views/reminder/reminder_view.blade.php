@extends('app')
{{-- include full calendar cdn --}}
@section('head')
    @include('include.fullcalenderCDN')
@endsection

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center text-primary">Reminders</h1>

                <div id="calendar"></div>
                !-- Modal -->
                @include('include.reminderAddModal')

                @include('include.reminderUpdateModal')
            </div>
        </div>
    </div>
</section>
@endsection
