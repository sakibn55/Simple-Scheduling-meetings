@component('mail::message')
# Welcome To Simple Scheduling APP

This is your Account Details

<strong>Name: </strong>{{$name}} <br>
<strong>Email: </strong>{{$email}}<br>
<strong>Password: </strong>{{$password}}<br>

@component('mail::button', ['url' => $url])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
