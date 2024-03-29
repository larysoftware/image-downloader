<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\ValueObject;

use InvalidArgumentException;

readonly class ImageContent
{
    public function __construct(public string $value)
    {
        if (empty($this->content)) {
            throw new InvalidArgumentException("file content can't be empty");
        }
    }
}