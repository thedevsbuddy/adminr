@props(['name' => 'help'])
<svg {{ $attributes->merge(['class' => "h-3 w-3"]) }}>
	<use xlink:href="{{ adminrIcon('cil-'.$name) }}"></use>
</svg>
