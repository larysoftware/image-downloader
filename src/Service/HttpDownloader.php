<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Service;

use Lssoftware\ImageDownloader\Dto\ImageResponse;
use Lssoftware\ImageDownloader\Dto\ContentFile;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

readonly class HttpDownloader
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function get(RequestInterface $request): ContentFile
    {
        $response = $this->request($request);
        return new ContentFile(
            $response->getImageContent(),
            $response->getExtension(),
            $response->getImageDimensions(),
            $response->getFilesize()
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    private function request(RequestInterface $request): ImageResponse
    {
        return new ImageResponse($this->client->sendRequest($request));
    }
}
