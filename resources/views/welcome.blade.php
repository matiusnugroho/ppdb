<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Meta Description -->
    <meta name="description" content="Selamat datang di PPDB Kuantan Singingi. Daftar sekolah kini lebih mudah dan cepat dengan PPDB online!">
    <meta name="keywords" content="ppd, ppdb kuansing, PPDB, Kuantan Singingi, pendaftaran sekolah online, PPDB online">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="PPDB Kuantan Singingi">
    <meta property="og:description" content="Selamat datang di PPDB Kuantan Singingi. Daftar sekolah kini lebih mudah dan cepat dengan PPDB online!">
    <meta property="og:image" content="{{ asset('logokuansing.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Stylesheet with Cache-Busting -->
    <link rel="stylesheet" crossorigin href="{{ asset('index.css') }}?v={{ time() }}">
</head>
<body>
    <div id="app"></div>

    <!-- JavaScript with Cache-Busting -->
    <script type="module" crossorigin src="{{ asset('index.js') }}?v={{ time() }}"></script>
</body>
</html>
