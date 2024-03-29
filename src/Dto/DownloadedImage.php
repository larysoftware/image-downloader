<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Dto;

use Lssoftware\ImageDownloader\ValueObject\ImageName;
use Lssoftware\ImageDownloader\ValueObject\ImageDimensions;
use Lssoftware\ImageDownloader\ValueObject\ImageExtension;
use Lssoftware\ImageDownloader\ValueObject\ImageSize;

readonly class DownloadedImage
{
    public function __construct(
        public ImageName $name,
        public ImageExtension $extension,
        public ImageDimensions $dimensions,
        public ImageSize $size
    ) {
    }
}