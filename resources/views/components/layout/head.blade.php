<!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'Corporate Merchant Portal' }}</title>

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logos/favicon.png') }}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">

<!-- Vite Config -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Core Css (Theme defaults not handled by Vite/Tailwind) -->
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}?v={{ time() }}" />
