<?php
$manifestPath = public_path('app/.vite/manifest.json');
$manifest = json_decode(file_get_contents($manifestPath), true);
$cssFile = $manifest['index.html']['css'][0];
$mainJS = $manifest['index.html']['file'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('app/' . $cssFile) }}">
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('app/' . $mainJS) }}"></script>
</body>
</html>
