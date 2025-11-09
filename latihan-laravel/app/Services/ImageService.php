<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Simpan file gambar ke storage publik.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $directory
     * @return string path yang disimpan
     */
    public function store(UploadedFile $file, string $directory = 'covers'): string
    {
        return $file->store($directory, 'public');
    }

    /**
     * Hapus file lama jika ada.
     *
     * @param  string|null  $path
     * @return void
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Ganti file lama dengan yang baru.
     *
     * @param  \Illuminate\Http\UploadedFile|null  $file
     * @param  string|null  $oldPath
     * @param  string  $directory
     * @return string|null
     */
    public function replace(?UploadedFile $file, ?string $oldPath, string $directory = 'covers'): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        // hapus lama
        $this->delete($oldPath);

        // simpan baru
        return $this->store($file, $directory);
    }
}
