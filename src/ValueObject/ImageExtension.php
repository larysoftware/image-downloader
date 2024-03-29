<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\ValueObject;

use InvalidArgumentException;

readonly class ImageExtension
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("extension can't be empty");
        }
    }
}