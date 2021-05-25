<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#4f89d0" />
    <script src="https://kit.fontawesome.com/fd0c6609cb.js" crossorigin="anonymous"></script>
    <link href="{{ asset('styles/tailwind.min.css') }}" rel="stylesheet">
    <title>Bilancio Sociale {{ config('bs.year') + 1 }}</title>
    <style>
    .odd\:bg-white:nth-child(odd) {
      background-color: white;
    }
    </style>
  </head>
  <body class="relative text-gray-800 antialiased bg-gray-100">
    <div class="flex p-4 bg-white justify-center">
      <img class="flex-1-auto" src="{{ asset('/res/logo.jpg') }}" width="250">
    </div>

    <div class="relative bg-blue-400 md:pt-8 pb-24 pt-8">
      <h2 class="block pb-8 text-white text-center text-3xl font-semibold">Bilancio Sociale {{ config('bs.year') + 1 }}</h2>
      <div class="px-4 md:px-10 mx-auto w-full">
        <div>
          @yield('cards')
        </div>
      </div>
    </div>

    <div class="px-4 md:px-10 mx-auto w-full -m-24">
      @yield('content')
    </div>

    @stack('custom-scripts')
  </body>
</html>
