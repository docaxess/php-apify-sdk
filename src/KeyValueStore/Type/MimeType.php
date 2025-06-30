<?php

declare(strict_types=1);

namespace DocAxess\Apify\KeyValueStore\Type;

enum MimeType: string
{
    case PDF = 'application/pdf';
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case GIF = 'image/gif';
    case WEBP = 'image/webp';
    case SVG = 'image/svg+xml';
    case OCTET_STREAM = 'application/octet-stream';

    public static function fromExtension(string $extension): self
    {
        return match (strtolower($extension)) {
            'pdf' => self::PDF,
            'jpg', 'jpeg' => self::JPEG,
            'png' => self::PNG,
            'gif' => self::GIF,
            'webp' => self::WEBP,
            'svg' => self::SVG,
            default => self::OCTET_STREAM,
        };
    }

    public static function fromFilename(string $filename): self
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return self::fromExtension($extension);
    }
}
