<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Portal - {{ $tenant->name ?? 'Antrian' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
  </head>
  <body class="bg-base-200 font-sans">
    <header class="bg-base-100 shadow p-4">
      <h1 class="text-xl font-bold">{{ $tenant->name ?? 'Antrian' }}</h1>
    </header>

    <main class="container mx-auto mt-6">
      {{ $slot }}
    </main>

    @livewireScripts
  </body>
</html>
