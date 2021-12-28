@component('mail::message')
{!! $body !!}


This is a testing mail.
## Congrats it's working....!
Thanks,<br>
{{ getSetting('app_name') }} <br>
{{ getSetting('app_tagline') }}
@endcomponent
