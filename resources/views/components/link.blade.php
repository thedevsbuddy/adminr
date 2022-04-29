@props(['as' => 'link', 'method' => 'get', 'href' => '#'])


@if($as == 'link')
    <a {{ $attributes->merge(['href' => $href]) }}>
        {{ $slot }}
    </a>
@endif

@if($as == 'form')
    <form action="{{ $href }}" method="{{ $method }}">
        @if(strtoupper($method) == 'POST' || strtoupper($method) == 'PUT')
            @csrf
        @endif
        <button {{ $attributes->merge(["type" => "submit"]) }}>{{ $slot }}</button>
    </form>
@endif
