@component('mail::message')
# New Appointment Scheduled

<strong>Title: </strong>{{$title}} <br>
<strong>Description: </strong>{{$description}} <br>
<strong>Location_title: </strong>{{$location_title}} <br>
<strong>Lattitude: </strong>{{$lattitude}} <br>
<strong>Longitude: </strong>{{$longitude}} <br>
<strong>Starting Time: </strong>{{$start}} <br>
<strong>Ending Time: </strong>{{$end}} <br>

@component('mail::button', ['url' => $url])
Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
