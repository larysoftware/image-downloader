<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Service;

use Lssoftware\ImageDownloader\Dto\ImageResponse;
use Lssoftware\ImageDownloader\Dto\ContentFile;
use GuzzleHttp\Client;

readonly class HttpDownloader
{
    private Client $client;
    public function __construct()
    {
        $this->client = new Client([]);
    }

    public function get(string $path): ContentFile
    {
        $response = $this->request($path);
        return new ContentFile(
            $response->getImageContent(),
            $response->getExtension(),
            $response->getImageDimensions(),
            $response->getFilesize()
        );
    }

    private function request(string $path): ImageResponse
    {
        return new ImageResponse($this->client->request('GET', $path));
    }
}
