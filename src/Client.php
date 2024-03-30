<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader;

use Lssoftware\ImageDownloader\Collection\DownloadedResultCollection;
use Lssoftware\ImageDownloader\Collection\ImagesSourceCollection;
use Lssoftware\ImageDownloader\Dto\DownloadedResult;
use Lssoftware\ImageDownloader\Service\HttpDownloader;
use Lssoftware\ImageDownloader\Service\ImageWriter;
use Psr\Log\LoggerInterface;
use Throwable;

readonly class Client
{

    public function __construct(
        public ImageWriter $imageWriter,
        private LoggerInterface $logger,
        private HttpDownloader $downloader,
    ) {
    }

    public function download(ImagesSourceCollection $imagesCollection): DownloadedResultCollection
    {
        $resultCollection = new DownloadedResultCollection();
        foreach ($imagesCollection as $image) {
            try {
                $resultCollection->append(
                    new DownloadedResult(
                        $image,
                        $this->imageWriter->save(
                            $this->downloader->get($image->value)
                        )
                    )
                );
            } catch (Throwable $exception) {
                $this->logger->info($exception->getMessage(), [$image]);
            }
        }
        return $resultCollection;
    }
}