<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Dto;

use InvalidArgumentException;

use function preg_match;

readonly class ImageSourceUrl
{
    public function __construct(public string $value)
    {
        if (empty($this->value)) {
            throw new InvalidArgumentException("image source cant be empty");
        }

        if (!preg_match("#^https?://.+#", $this->value)) {
            throw new InvalidArgumentException('source is not valid url');
        }
    }
}