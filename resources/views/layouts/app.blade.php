<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SD Negeri Legok III')</title>
    <link rel="icon" href="{{ asset('image/Logo4.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&family=Playfair+Display:wght@400;600;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    {{-- CSS tambahan dari tiap halaman --}}
    @yield('styles')
</head>
<body>

    {{-- Loader otomatis muncul di semua halaman --}}
    @include('components.loader')

    {{-- Konten tiap halaman masuk sini --}}
    @yield('content')

    {{-- JS tambahan dari tiap halaman --}}
    @yield('scripts')

</body>
</html>