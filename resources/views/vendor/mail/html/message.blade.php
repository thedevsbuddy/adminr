@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
    <img src="{{ asset(getSetting('app_logo')) }}" class="logo" alt="{{ getSetting('app_name') }}">
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
&copy; {{ date('Y') }} <a href="{{ url('/') }}" target="_blank">{{ getSetting('app_name') }}</a>. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
