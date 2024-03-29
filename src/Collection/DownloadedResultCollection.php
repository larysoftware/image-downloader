<?php

declare(strict_types=1);

namespace Lssoftware\ImageDownloader\Collection;

use Lssoftware\ImageDownloader\Dto\DownloadedResult;
use Countable;
use Iterator;

use function count;

class DownloadedResultCollection implements Countable, Iterator
{
    private int $position = 0;

    /**
     * @var DownloadedResult[]
     */
    private array $result;

    public function __construct(DownloadedResult ...$result)
    {
        $this->result = $result;
    }

    public function append(DownloadedResult $downloadResult): void
    {
        $this->result[] = $downloadResult;
    }

    public function current(): ?DownloadedResult
    {
        return $this->result[$this->position] ?? null;
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
        return count($this->result);
    }
}