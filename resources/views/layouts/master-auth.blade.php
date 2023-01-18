<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supplium</title>

    @wireUiScripts
    @vite(['resources/js/app.js'])
    @vite('resources/css/app.css')
    @livewireStyles
    @powerGridStyles
    <style>
      [x-cloak] { display: none !important; }
    </style>
  
</head>
<body>
  <x-notifications />
  
    <div>
      {{ $slot }}
    </div>

    @livewire('livewire-ui-modal')
    @livewireScripts
    @powerGridScripts
</body>
</html>