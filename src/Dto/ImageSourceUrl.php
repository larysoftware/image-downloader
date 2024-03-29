<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Dto;

use InvalidArgumentException;

readonly class ImageSourceUrl
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("image source cant be empty");
        }
    }
}