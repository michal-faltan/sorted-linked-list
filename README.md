# SortedLinkedList

A simple, type-safe, sorted singly linked list implementation in PHP supporting `int` or `string` values — but not both in the same list.

## Features

- Maintains **ascending order** on every insertion.
- Enforces **single scalar type** (`int` or `string`) throughout the list.
- Supports common list operations:
  - `insert()`
  - `delete()`
  - `deleteAllOf()`
  - `find()`
  - `exists()`
  - `clear()`
  - `toArray()`

## Installation

You can include this class in your project via Composer:

```bash
composer require mf-miko/sorted-linked-list
```

## Usage
```php
use Miko\SortedLinkedList\SortedLinkedList;

$list = new SortedLinkedList();
$list->insert(10);
$list->insert(5);
$list->insert(20);

print_r($list->toArray()); // [5, 10, 20]

$list->delete(10);
print_r($list->toArray()); // [5, 20]

echo $list->exists(5); // true

$list->clear();
```

## Type enforcement
First value inserted determines type accepted by particular instance of **SortedLinkedList**. Any future insert of a mismatched type will throw `InvalidArgumentException`. Function clear() resets the type enforcement.

```php
$list = new SortedLinkedList();
$list->insert("apple");     // OK
$list->insert("banana");    // OK
$list->insert(42);          // ❌ InvalidArgumentException
```
