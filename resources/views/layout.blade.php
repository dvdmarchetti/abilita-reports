<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <script src="https://kit.fontawesome.com/fd0c6609cb.js" crossorigin="anonymous"></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.2.0/tailwind.min.css" /> --}}
    <link href="{{ asset('styles/tailwind.min.css') }}" rel="stylesheet">
    <title>Bilancio Sociale {{ date('Y') - 1 }}</title>
    <style>
    .odd\:bg-white:nth-child(odd) {
      background-color: white;
    }
    </style>
  </head>
  <body class="text-gray-800 antialiased bg-gray-100">
    <div class="relative bg-pink-500 md:pt-12 pb-24 pt-12">
      <div class="px-4 md:px-10 mx-auto w-full">
        <div>
          @yield('cards')
        </div>
      </div>
    </div>

    <div class="px-4 md:px-10 mx-auto w-full -m-24">
      @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" charset="utf-8"></script>
  </body>
</html>