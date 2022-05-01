@component('mail::message')
{!! $body !!}

Regards,<br>
**{{ getSetting('app_name') }}** <br>
{{ getSetting('app_tagline') }}
@endcomponent
