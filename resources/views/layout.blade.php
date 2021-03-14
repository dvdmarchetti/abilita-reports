<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#60a5fa" />
    <script src="https://kit.fontawesome.com/fd0c6609cb.js" crossorigin="anonymous"></script>
    <link href="{{ asset('styles/tailwind.min.css') }}" rel="stylesheet">
    <title>Bilancio Sociale {{ date('Y') - 1 }}</title>
    <style>
    .odd\:bg-white:nth-child(odd) {
      background-color: white;
    }
    </style>
  </head>
  <body class="text-gray-800 antialiased bg-gray-100">
    <div class="flex p-4 bg-white justify-center">
      <img class="flex-1-auto" src="{{ asset('/res/logo.jpg') }}" width="250">
    </div>

    <div class="relative bg-blue-400 md:pt-12 pb-24 pt-12">
      <div class="px-4 md:px-10 mx-auto w-full">
        <div>
          @yield('cards')
        </div>
      </div>
    </div>

    <div class="px-4 md:px-10 mx-auto w-full -m-24">
      @yield('content')
    </div>
  </body>
</html>
