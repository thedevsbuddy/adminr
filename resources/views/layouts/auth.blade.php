
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', config('app.name')) {{ getSetting('title_separator') }} {{ getSetting('app_name') }} {{ getSetting('title_separator') }} {{ getSetting('app_tagline') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset(getSetting('app_favicon')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminr/css/coreui.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminr-engine/css/adminr-engine.css') }}">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />--}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    @stack('scopedCss')
</head>
<body class="c-app flex-row align-items-center">

@yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.2/perfect-scrollbar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@3.4.0/dist/js/coreui.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('vendor/adminr-engine/js/adminr-engine.js') }}"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
    }
</script>

@if(session('success'))
<script>
    toastr.success({{session('success')}})
</script>
@endif

@if(session('error'))
    <script>
        toastr.error({{session('error')}})
    </script>
@endif

@stack('scopedJs')
</body>
</html>
