<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Dto;

use Lssoftware\ImageDownloader\ValueObject\ImageContent;
use Lssoftware\ImageDownloader\ValueObject\ImageDimensions;
use Lssoftware\ImageDownloader\ValueObject\ImageExtension;
use Lssoftware\ImageDownloader\ValueObject\ImageSize;

readonly class ContentFile
{
    public function __construct(
        public ImageContent $content,
        public ImageExtension $extension,
        public ImageDimensions $dimensions,
        public ImageSize $size
    ) {
    }
}