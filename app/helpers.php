<?php

if (! function_exists('vite_asset')) {
    function vite_asset($path)
    {
        $manifestPath = public_path('app/.vite/manifest.json');
        if (! file_exists($manifestPath)) {
            throw new Exception('The Vite manifest file does not exist. Please build the frontend assets.');
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);

        // Handle different types of paths
        $key = $path;
        if (! isset($manifest[$key])) {
            throw new Exception("Unable to find asset in manifest: {$path}");
        }

        return asset('app/'.$manifest[$key]['file']);
    }
}
