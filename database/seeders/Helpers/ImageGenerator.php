<?php

namespace Database\Seeders\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ImageGenerator
{
    /**
     * Génère une image placeholder colorée avec des initiales.
     * Utilise le service ui-avatars.com (gratuit, pas de clé API).
     */
    public static function avatar(string $name, string $path): string
    {
        $url = 'https://ui-avatars.com/api/?'
            . http_build_query([
                'name'       => $name,
                'size'       => 400,
                'background' => '2563eb',
                'color'      => 'ffffff',
                'format'     => 'png',
                'bold'       => 'true',
                'font-size'  => 0.4,
            ]);

        return self::download($url, $path);
    }

    /**
     * Génère un screenshot placeholder avec des dimensions 16:9.
     * Utilise placehold.co (gratuit).
     */
    public static function screenshot(string $text, string $path, string $bgColor = '1e293b', string $textColor = 'e2e8f0'): string
    {
        $encodedText = urlencode($text);
        $url = "https://placehold.co/1280x720/{$bgColor}/{$textColor}/png?text={$encodedText}&font=roboto";

        return self::download($url, $path);
    }

    /**
     * Génère un logo carré placeholder.
     */
    public static function logo(string $name, string $path, string $bgColor = '3b82f6'): string
    {
        $url = 'https://ui-avatars.com/api/?'
            . http_build_query([
                'name'       => $name,
                'size'       => 200,
                'background' => $bgColor,
                'color'      => 'ffffff',
                'format'     => 'png',
                'rounded'    => 'true',
                'bold'       => 'true',
            ]);

        return self::download($url, $path);
    }

    /**
     * Génère une image de couverture pour les articles de blog.
     */
    public static function coverImage(string $text, string $path): string
    {
        $encodedText = urlencode($text);
        $url = "https://placehold.co/1280x720/2563eb/ffffff/png?text={$encodedText}&font=roboto";

        return self::download($url, $path);
    }

    /**
     * Télécharge une image et la stocke dans le storage Laravel.
     */
    private static function download(string $url, string $storagePath): string
    {
        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                // Créer le dossier si nécessaire
                $directory = dirname($storagePath);
                Storage::disk('public')->makeDirectory($directory);

                // Sauvegarder l'image
                Storage::disk('public')->put($storagePath, $response->body());

                return $storagePath;
            }
        } catch (\Throwable $e) {
            // Si le téléchargement échoue, on continue sans image
            logger()->warning("Image generation failed for {$storagePath}: {$e->getMessage()}");
        }

        return '';
    }

    /**
     * Méthode de fallback : crée une image simple avec GD si les URLs externes sont bloquées.
     */
    public static function generateLocal(string $text, string $path, int $width = 400, int $height = 400): string
    {
        if (!extension_loaded('gd')) {
            return '';
        }

        $image = imagecreatetruecolor($width, $height);
        $bgColor = imagecolorallocate($image, 37, 99, 235);  // Bleu primary
        $textColor = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $bgColor);

        // Texte centré (initiales)
        $initials = collect(explode(' ', $text))
            ->map(fn($word) => strtoupper(mb_substr($word, 0, 1)))
            ->take(2)
            ->join('');

        $fontSize = 5; // Taille de police GD intégrée
        $textWidth = strlen($initials) * imagefontwidth($fontSize);
        $textHeight = imagefontheight($fontSize);
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;

        imagestring($image, $fontSize, (int) $x, (int) $y, $initials, $textColor);

        // Sauvegarder
        $directory = dirname($path);
        Storage::disk('public')->makeDirectory($directory);

        $fullPath = Storage::disk('public')->path($path);
        imagepng($image, $fullPath);
        imagedestroy($image);

        return $path;
    }
}