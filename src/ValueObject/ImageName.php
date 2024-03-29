<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\ValueObject;

use InvalidArgumentException;

readonly class ImageName
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("image name can't be empty");
        }
    }
}