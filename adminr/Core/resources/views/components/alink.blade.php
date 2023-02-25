@props(['as' => 'link', 'method' => 'get', 'href' => '#', 'formClass' => '',
	'confirmTitle' => 'Are you sure?',
	'confirmMessage' => 'You won\'t be able to revert this!',
	'confirmIcon' => 'warning',
	'confirmLabel' => 'Yes, delete it!',
])


@if($as == 'link')
	<a {{ $attributes->merge(['href' => $href]) }}>
		{{ $slot }}
	</a>
@elseif($as == 'form')
	@php($formMethod = 'POST')
	@if(strtoupper($method) != 'GET' || strtoupper($method) != 'POST')
		@php($formMethod = 'POST')
	@else
		@php($formMethod = $method)
	@endif
	<form action="{{ $href }}" method="{{ strtoupper($formMethod) }}" class="d-inline-block {{ $formClass }}"
	      data-message="{{ $confirmMessage }}"
	      data-title="{{ $confirmTitle }}"
	      data-icon="{{ $confirmIcon }}"
	      data-confirm="{{ $confirmLabel }}"
	>
		@if(strtoupper($method) != 'GET')
			@csrf
		@endif
		@if(strtoupper($method) != 'GET' || strtoupper($method) != 'POST')
			@method(strtoupper($method))
		@endif
		<button {{ $attributes->merge(["type" => "submit"]) }}>{{ $slot }}</button>
	</form>
@endif
