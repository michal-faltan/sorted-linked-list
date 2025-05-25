<?php declare(strict_types=1);

namespace Miko\SortedLinkedList;

class Node 
{
    /**
     * @var int|string
     */
    private $value;

    /**
     * @var Node|null
     */
    private $next;

    public function __construct(int|string $value)
    {
        $this->value = $value;
        $this->next = null;
    }

    public function setNext(?Node $node) : void
    {
        $this->next = $node;
    }

    public function getNext() : ?Node
    {
        return $this->next;
    }

    public function getValue() : int|string
    {
        return $this->value;
    }
}
