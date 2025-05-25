<?php declare(strict_types=1);

namespace Miko\SortedLinkedList\Tests;

use PHPUnit\Framework\TestCase;
use Miko\SortedLinkedList\SortedLinkedList;
use Miko\SortedLinkedList\Node;
use ReflectionProperty;
use TypeError;
use InvalidArgumentException;

final class SortedLinkedListTest extends TestCase
{
    public function testToArrayWhenEmpty(): void
    {
        $list = new SortedLinkedList();
        $this->assertSame([], $list->toArray());
    }

    public function testInsertMaintainsSortedOrderWithIntegers(): void
    {
        $list = new SortedLinkedList();
        $list->insert(3);
        $list->insert(1);
        $list->insert(2);

        $this->assertSame([1, 2, 3], $list->toArray());
    }

    public function testInsertMaintainsSortedOrderWithStrings(): void
    {
        $list = new SortedLinkedList();
        $list->insert('banana');
        $list->insert('apple');
        $list->insert('cherry');

        $this->assertSame(['apple', 'banana', 'cherry'], $list->toArray());
    }

    public function testInsertingMixedTypesThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert("string");
    }

    public function testInsertNonIntOrStringThrowsTypeError(): void
    {
        $this->expectException(TypeError::class);

        $list = new SortedLinkedList();
        $list->insert([]);
    }

    public function testFindReturnsCorrectNode(): void
    {
        $list = new SortedLinkedList();
        $list->insert("alpha");
        $list->insert("beta");

        $node = $list->find("beta");
        $this->assertInstanceOf(Node::class, $node);
        
        $value = (new ReflectionProperty($node, 'value'));
        $value->setAccessible(true);
        $this->assertSame("beta", $value->getValue($node));
    }

    public function testExistsReturnsFalseWhenTypeMismatch(): void
    {
        $list = new SortedLinkedList();
        $list->insert(20);
        $this->assertFalse($list->exists('20'));
    }

    public function testExistsReturnsTrueWhenFound(): void
    {
        $list = new SortedLinkedList();
        $list->insert(42);
        $this->assertTrue($list->exists(42));
    }

    public function testExistsReturnsFalseWhenNotFound(): void
    {
        $list = new SortedLinkedList();
        $list->insert(42);
        $this->assertFalse($list->exists(13));
    }

    public function testDeleteRemovesNode(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);
        $list->insert(3);

        $list->delete(2);
        $this->assertSame([1, 3], $list->toArray());
    }

    public function testDeleteHeadNode(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);

        $list->delete(1);
        $this->assertSame([2], $list->toArray());
    }

    public function testDeleteAllOf(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);
        $list->insert(3);
        $list->insert(2);
        $list->deleteAllOf(2);

        $this->assertSame([1,3], $list->toArray());
    }

    public function testDeleteAllOfStartingWithHead(): void
    {
        $list = new SortedLinkedList();
        $list->insert(2);
        $list->insert(2);
        $list->insert(2);
        $list->insert(3);
        $list->deleteAllOf(2);

        $this->assertSame([3], $list->toArray());
    }

    public function testClearLinkedList(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);
        $list->clear();

        $this->assertSame([], $list->toArray());
    }

    public function testClearLinkedListResetsType(): void
    {
        $list = new SortedLinkedList();
        $list->insert(1);
        $list->insert(2);
        $list->clear();
        $list->insert('string');

        $this->assertSame(['string'], $list->toArray());
    }
}
