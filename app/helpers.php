<?php

use App\Models\Registration;

if (! function_exists('generateRegistrationNumber')) {
    function generateRegistrationNumber(string $jenjang)
    {
        // Query the last registration number for the same jenjang
        $lastRegistration = Registration::where('registration_number', 'like', "$jenjang%")
            ->orderBy('registration_number', 'desc')
            ->first();

        // If a registration exists, extract and increment the numeric part
        if ($lastRegistration) {
            // Extract the numeric part from the registration number
            $lastNumber = (int) substr($lastRegistration->registration_number, strlen($jenjang));

            // Increment the last number
            $newNumber = $lastNumber + 1;
        } else {
            // If no previous registration exists for this jenjang, start at 1
            $newNumber = 1;
        }

        // Return the new registration number in the format jenjang000001
        return $jenjang.str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
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
