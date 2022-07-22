<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterventionImage;

class ImageDecorator
{
    public InterventionImage $image;

    /**
     * The constructor is private you need to call make to create an instance.
     */
    protected function __construct()
    {
    }

    public static function checkIsAPNG(string $file): bool
    {
        $img_bytes = file_get_contents($file);

        return ! ($img_bytes && str_contains(substr($img_bytes, 0, strpos($img_bytes, 'IDAT')), 'acTL'));
    }

    public static function make(string $file): self
    {
        $self = new self();
        $self->image = Image::make($file);

        return $self;
    }

    public function resize(int $width, int $height, bool $keepProportions = false): ImageDecorator
    {
        $this->image->resize(
            $width,
            $height,
            $keepProportions ? static fn ($constraint) => $constraint->aspectRatio() : null
        );

        return $this;
    }

    public function encode(string $encoding, int $quality = 50): ImageDecorator
    {
        $this->image->encode($encoding, $quality);

        return $this;
    }

    public function save(string $path, string $name = null, string $extension = null): string
    {
        $this->image->stream();
        $extension ??= $this->getExtension();
        $name ??= self::generateRandomFileName($extension);

        $fullPath = $path.$name;

        Storage::disk('public')->put(
            $fullPath,
            $this->image
        );

        return $fullPath;
    }

    public static function generateRandomFileName(string $extension): string
    {
        return str_replace(
            ['.', '/', '\\'],
            '',
            Hash::make(
                uniqid(time(), true)
            )
        ).'.'.$extension;
    }

    public function getExtension(): string
    {
        return $this->image->extension !== 'tmp' ? $this->image->extension : match ($this->image->mime()) {
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }
}
