<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Dto;

readonly class DownloadedResult
{
    public function __construct(
        public ImageSourceUrl $source,
        public DownloadedImage $destination
    ) {
    }
}