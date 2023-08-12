<?php

namespace App\Traits;

trait ImageTrait
{
    public function uploadImage($file, string $path): string
    {
        return $file->store(
            'assert/' . $path,
            'public'
        );
    }

    public function deleteImage(string $image): void
    {
        $image = substr($image,22);
        if (file_exists($image)) {
            unlink($image);
        }
    }

}
