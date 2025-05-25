<?php declare(strict_types=1);

namespace Miko\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use Miko\SortedLinkedList\Node;
use ReflectionProperty; 

final class NodeTest extends TestCase
{
    public function testConstructorSetsValueAndNextIsNull(): void
    {
        $node = new Node('test');

        // Use reflection to access private properties
        $refValue = new ReflectionProperty(Node::class, 'value');
        $refValue->setAccessible(true);
        $refNext = new ReflectionProperty(Node::class, 'next');
        $refNext->setAccessible(true);

        $this->assertSame('test', $refValue->getValue($node));
        $this->assertNull($refNext->getValue($node));
    }

    public function testSetNextWorks(): void
    {
        $first = new Node('a');
        $second = new Node('b');

        $first->setNext($second);

        $refNext = new ReflectionProperty(Node::class, 'next');
        $refNext->setAccessible(true);

        $this->assertSame($second, $refNext->getValue($first));
    }

    public function testGetNextWorksOnEmptySuccessor(): void
    {
        $node = new Node('a');
        $refNext = new ReflectionProperty(Node::class, 'next');
        $refNext->setAccessible(true);

        $this->assertSame($node->getNext(), $refNext->getValue($node));
    }

    public function testGetNextWorks(): void
    {
        $first = new Node('a');
        $second = new Node('b');

        $first->setNext($second);

        $refNext = new ReflectionProperty(Node::class, 'next');
        $refNext->setAccessible(true);

        $this->assertSame($first->getNext(), $refNext->getValue($first));
    }

    public function testGetValueWorks(): void
    {
        $node = new Node('a');
        $refValue = new ReflectionProperty(Node::class, 'value');
        $refValue->setAccessible(true);

        $this->assertSame($node->getValue(), $refValue->getValue($node));
    }
}
