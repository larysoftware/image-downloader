<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Exception;

use Exception;

class MimeTypeIsNotSupportedImage extends Exception
{
    protected $message = 'mime type is not supported image';
}