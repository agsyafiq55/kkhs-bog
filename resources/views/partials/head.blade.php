<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'KKHSbog' }}</title>

{{-- ✅ CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ✅ Livewire Styles --}}
@livewireStyles

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
