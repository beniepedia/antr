<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Portal - {{ app('tenant')->name ?? 'Antrian' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
  </head>
  <body class="bg-base-200 font-sans">
    <main class="min-h-screen">
      {{ $slot }}
    </main>
    @livewireScripts
  </body>
</html>

