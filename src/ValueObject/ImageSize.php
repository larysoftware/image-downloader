<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\ValueObject;

use InvalidArgumentException;

readonly class ImageSize
{
    public function __construct(public int $value)
    {
        if ($this->value < 1) {
            throw new InvalidArgumentException("size can't be less than 1");
        }
    }
}