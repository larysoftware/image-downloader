<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Service;

use Lssoftware\ImageDownloader\Dto\ContentFile;
use Lssoftware\ImageDownloader\Dto\DownloadedImage;
use Lssoftware\ImageDownloader\ValueObject\ImageName;
use Ramsey\Uuid\Nonstandard\Uuid;

use const DIRECTORY_SEPARATOR;

readonly class ImageWriter
{
    public function __construct(private string $directoryPath)
    {
    }

    public function save(ContentFile $fileContent): DownloadedImage
    {
        $name = $this->createFileName($fileContent);
        $this->storeFile($name, $fileContent);
        return new DownloadedImage(
            $name,
            $fileContent->extension,
            $fileContent->dimensions,
            $fileContent->size
        );
    }

    public function removeImageByName(ImageName $file): void
    {
        @unlink($this->directoryPath . DIRECTORY_SEPARATOR . $file->value);
    }

    private function createFileName(ContentFile $file): ImageName
    {
        return new ImageName(Uuid::uuid4()->toString() . '.' . $file->extension->value);
    }

    private function storeFile(ImageName $name, ContentFile $fileContent): void
    {
        file_put_contents($this->directoryPath . DIRECTORY_SEPARATOR . $name->value, $fileContent->content);
    }
}