<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Exception;

use Exception;

class ContentFileIsNotImage extends Exception
{
    protected $message = 'content file is not image';
}