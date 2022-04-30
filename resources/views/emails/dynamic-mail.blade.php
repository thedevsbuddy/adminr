@component('mail::message')
{!! $body !!}

Regards,<br>
<a href="{{ url('/') }}">{{ getSetting('app_name') }}</a> <br>
{{ getSetting('app_tagline') }}
@endcomponent
