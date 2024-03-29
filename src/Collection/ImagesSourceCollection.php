<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Collection;

use Countable;
use Iterator;
use Lssoftware\ImageDownloader\Dto\ImageSourceUrl;

use function count;

class ImagesSourceCollection implements Iterator, Countable
{
    private int $position = 0;

    /**
     * @var ImageSourceUrl[]
     */
    private array $images;


    public function __construct(ImageSourceUrl ...$images)
    {
        $this->images = $images;
    }

    public function current(): ?ImageSourceUrl
    {
        return $this->images[$this->position] ?? null;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return $this->position >= 0 && $this->position < $this->count();
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->images);
    }
}