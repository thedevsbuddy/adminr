@props(['containerId' => null, 'label' => 'Select image', 'src' => null])

<div class="text-center">
    <label class="circle-file-input mx-auto" id="{{$containerId}}" style="background-image: url({{$src}})">
        <input type="file" class="d-none file-input" {{ $attributes }}>
        <svg class="mr-1 text-dark w-100 ml-2 mb-1 file-input-icon" style="height: 25px;">
            <use xlink:href="{{ coreUiIcon('cil-camera') }}"></use>
        </svg>
    </label>
    <label for="site_favicon" class="btn btn-default">{{ $label }}</label>
</div>