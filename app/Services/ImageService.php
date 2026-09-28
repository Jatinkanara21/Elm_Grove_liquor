<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /** Stores an upload on the public disk, downscaling and re-encoding it when GD is available. */
    public function store(UploadedFile $file, string $directory, int $maxWidth = 1600): string
    {
        $ext = match ($file->getMimeType()) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };

        $path = trim($directory, '/') . '/' . Str::uuid() . '.' . $ext;
        $data = extension_loaded('gd') ? $this->optimise($file->getRealPath(), $ext, $maxWidth) : null;

        Storage::disk('public')->put($path, $data ?? file_get_contents($file->getRealPath()));

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function optimise(string $file, string $ext, int $maxWidth): ?string
    {
        $img = match ($ext) {
            'png' => @imagecreatefrompng($file),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file) : false,
            default => @imagecreatefromjpeg($file),
        };

        if (! $img) {
            return null;
        }

        // Respect camera orientation (re-encoding drops the EXIF tag).
        if ($ext === 'jpg' && function_exists('exif_read_data')) {
            $orientation = @exif_read_data($file)['Orientation'] ?? 1;
            $angle = [3 => 180, 6 => -90, 8 => 90][$orientation] ?? 0;
            if ($angle && ($rotated = imagerotate($img, $angle, 0))) {
                $img = $rotated;
            }
        }

        if (imagesx($img) > $maxWidth && ($scaled = imagescale($img, $maxWidth, -1, IMG_BICUBIC))) {
            $img = $scaled;
        }

        if ($ext !== 'jpg') {
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }

        ob_start();
        match ($ext) {
            'png' => imagepng($img, null, 8),
            'webp' => imagewebp($img, null, 82),
            default => imagejpeg($img, null, 85),
        };

        return ob_get_clean() ?: null;
    }
}