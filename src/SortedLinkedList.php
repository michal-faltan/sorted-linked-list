<?php declare(strict_types=1);

namespace Miko\SortedLinkedList;

use Miko\SortedLinkedList\Node;

/**
 * A sorted (ASC) singly linked list that stores values of a consistent scalar type (int or string).
 */
class SortedLinkedList 
{
    /**
     * @var Node|null
     */
    private $head;

    /**
     * @var string|null Either 'integer' or 'string', enforced after first insert.
     */
    private $type;

    public function __construct() 
    {
        $this->head = null;
        $this->type = null;
    }

    private function compare(int|string $a, int|string $b): int
    {
        return ($this->type === 'integer') ? ($a <=> $b) : strcmp($a, $b);
    }

    /**
     * @param int|string $value The value to insert.
     * @throws \InvalidArgumentException if the provided argument type does not match type of values already present in linked list
     */
    public function insert(string|int $value) : void
    {
        $valueType = gettype($value);

        if ($this->type === null) {
            $this->type = $valueType;
        } elseif ($this->type !== $valueType) {
            throw new \InvalidArgumentException("Cannot insert value of type $valueType into a list of type {$this->type}");
        }

        $node = new Node($value);
        if ($this->head === null) {
            $this->head = $node;
        } else {
            if ($this->compare($this->head->getValue(), $value) > 0) {
                $node->setNext($this->head);
                $this->head = $node;
            } else {
                $current = $this->head;
                while (($current->getNext() != null) and ($this->compare($current->getNext()->getValue(), $value) <= 0)){
                    $current = $current->getNext();
                }
                
                if ($current->getNext() === null) {
                    $current->setNext($node);
                } else if ($this->compare($current->getNext()->getValue(), $value) > 0) {
                    $node->setNext($current->getNext());
                    $current->setNext($node);
                } 
            }
        }
    }

    /**
     * Deletes the first occurrence of the given value from the list.
     *
     * @param int|string $value
     */
    public function delete(string|int $value) : void
    {
        if (isset($this->head)) {
            if ($this->head->getValue() === $value) {
                $this->head = $this->head->getNext();
            } else {
                $node = $this->head;
                while (($node->getNext() !== null) and ($node->getNext()->getValue() !== $value)) {
                    $node = $node->getNext();
                }
                if ($node->getNext() !== null) {
                    $node->setNext($node->getNext()->getNext());
                }
            }
        }
    }

    /**
     * Deletes all occurrences of the given value from the list.
     *
     * @param int|string $value
     */
    public function deleteAllOf(string|int $value) : void
    {
        while ($this->exists($value)) {
            $this->delete($value);
        }
    }

    /**
     * Clears the list and resets type enforcement.
     */
    public function clear() : void
    {
        $this->head = null;
        $this->type = null;
    }

    /**
     * Finds the first node containing the given value.
     *
     * @param int|string $value
     * @return Node|null
     */
    public function find(string|int $value): Node|null
    {
        $node = $this->head;
        while (isset($node) and ($node->getValue() !== $value)) {
            $node = $node->getNext();
        }

        return $node;
    }

    /**
     * Checks whether a value exists in the list.
     *
     * @param int|string $value
     * @return bool
     */
    public function exists(string|int $value): bool
    {
        return $this->find($value) !== null;
    }

    /**
     * Returns the values in the list as a plain array.
     *
     * @return array<int|string>
     */
    public function toArray() : array
    {
        $array = [];
        $node = $this->head;
        while (isset($node)) {
            $array[] = $node->getValue();
            $node = $node->getNext();
        }

        return $array;
    }
}