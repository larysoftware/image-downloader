<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\ValueObject;

use InvalidArgumentException;

class ImageDimensions
{
    public function __construct(public int $width, public int $height)
    {
        if ($this->width < 1) {
            throw new InvalidArgumentException("width can't be less than 1");
        }

        if ($this->height < 1) {
            throw new InvalidArgumentException("height can't be less than 1");
        }
    }
}