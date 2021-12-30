<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Work Sans", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
    </style>
</head>
<body>
<header class="bg-gray-100">
    <section class="border-b border-gray-300 bg-white shadow-sm fixed w-full top-0">
        <div class="container mx-auto py-2 px-3 max-w-screen-lg flex items-center justify-between">
            <div>
                <a href="#" class="text-2xl font-bold text-indigo-500">{{ getSetting('app_name') }}</a>
                <span class="text-xs text-gray-600 font-bold">v0.1</span>
            </div>
            <nav>
                <ul class="flex items-center">
                    <li>
                        <a href="https://github.com/thedevsbuddy/adminr"
                                       class="px-6 py-2 rounded flex items-center text-sm bg-indigo-500 hover:bg-indigo-600 text-gray-100 space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Download</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
    <section>
        <div class="container mx-auto px-3 mt-12 py-8 md:py-20 max-w-screen-lg flex flex-col items-center md:flex-row">
            <div class="space-y-4 md:space-y-6 md:w-1/2">
                <h1 class="text-3xl text-center md:text-left md:text-5xl font-bold text-gray-700 leading-tight">A simple
                    yet powerful Laravel project starter.</h1>
                <p class="text-lg md:text-xl text-center md:text-left text-gray-700">Build admin panel and generate
                    resources with ease using our
                    easy to use <span class="font-semibold">AdminR</span>.</p>

                <a href="https://github.com/thedevsbuddy/adminr"
                               class="px-6 py-2 px-6 rounded inline-flex items-center  text-base bg-indigo-500 hover:bg-indigo-600 focus:bg-indigo-600
                               focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 text-gray-100 space-x-2">
                    <span>Get started</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            <div class="md:w-1/2 ">
                <img src="{{ asset('assets/images/hero-section-image.svg') }}" class="w-5/6 block mx-auto" alt="">
            </div>
        </div>
    </section>
</header>
<section class=" px-3 py-6 md:py-20 bg-white">
    <div class="container mx-auto px-3 max-w-screen-lg">
        <h2 class="text-center text-gray-700 text-4xl font-semibold">Features</h2>
        <p class="text-center mt-2 text-lg text-gray-600">AdminR provides you some awesome features out of the box.</p>
        <div class="flex flex-col mx-auto md:flex-row mt-12 space-y-3 md:space-y-0 md:space-x-3">
            <div class="bg-white shadow hover:shadow-lg transition duration-500 border border-gray-100 text-center p-4 rounded">
                <img src="{{ asset('assets/images/feature-1.svg') }}" class="h-auto object-cover w-5/6 block mx-auto mb-6"
                     alt="Crud Generator">
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Crud Generator</h3>
                <p class="text-base text-gray-600">You can generate cruds with ease in <span
                            class="font-semibold">AdminR</span></p>
            </div>
            <div class="bg-white shadow hover:shadow-lg transition duration-500 border border-gray-100 text-center p-4 rounded">
                <img src="{{ asset('assets/images/feature-2.svg') }}" class="h-auto object-cover w-5/6 block mx-auto mb-6"
                     alt="Crud Generation">
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Manage Permissions</h3>
                <p class="text-base text-gray-600">You can manage permissions for each crud operation for every
                    resource.</p>
            </div>
            <div class="bg-white shadow hover:shadow-lg transition duration-500 border border-gray-100 text-center p-4 rounded">
                <img src="{{ asset('assets/images/feature-3.svg') }}" class="h-auto object-cover w-5/6 block mx-auto mb-6"
                     alt="Crud Generation">
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Auth/Public Api</h3>
                <p class="text-base text-gray-600">You can change each and every API endpoint to make it public or private.</p>
            </div>
        </div>
    </div>
</section>
</body>
</html>
