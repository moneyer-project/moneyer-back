<?php

namespace App\Service\Transfer;

use Doctrine\Common\Collections\ArrayCollection;

class TransferList implements \Iterator, \Countable
{
    protected ArrayCollection $collection;

    private int $position;

    public function __construct(?ArrayCollection $transfers = null)
    {
        $this->collection = $transfers ?? new ArrayCollection();
        $this->position = 0;
    }

    public function add(Transfer $transfer): void
    {
        $this->collection->add($transfer);
    }

    public function remove(Transfer $transfer): void
    {
        $this->collection->removeElement($transfer);
    }

    public function current(): mixed
    {
        return $this->collection->get($this->position);
    }

    public function next(): void
    {
        $this->position += 1;
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return $this->collection->containsKey($this->collection);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function first(): Transfer
    {
        return $this->collection->first();
    }

    public function filter(\Closure $p): TransferList
    {
        return $this->createFrom($this->collection->filter($p));
    }

    protected function createFrom(ArrayCollection $elements): TransferList
    {
        return new static($elements);
    }
}
