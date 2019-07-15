# Jasny PHP coding standard

This guide defines a set of rules aimed to create consistent code across all PHP projects of Jasny.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and
"OPTIONAL" in this document are to be interpreted as described in RFC 2119.

The term Application is used for deliverables that are typically served by a web server or run on the command line. The
term Library is used for a collection of classes and/or functions which is consumed by projects or other libraries.


## 1. PSR-1 and PSR-2

Jasny follows the [PSR-1 basic coding standard](http://www.php-fig.org/psr/psr-1/) and
[PSR-2 coding style guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

### 1.1. Exception on [Section 2.3 - Lines](http://www.php-fig.org/psr/psr-2/#2.3.-lines)

The following rule may be ignored:

> ~~Lines SHOULD NOT be longer than 80 characters; lines longer than that SHOULD be split into multiple subsequent lines of no more than 80 characters each.~~


## 2. Structure

### 2.1. Keywords

The keywords `AND` and `OR` SHOULD NOT be used. Instead use `&&` and `||`.

### 2.2. File length

PHP files SHOULD be 500 lines or less.

### 2.3. Function length

Functions and methods SHOULD be 30 lines or less.

### 2.4. Alternative syntax for control structures

The [alternative syntax for control structures](http://php.net/manual/en/control-structures.alternative-syntax.php)
MUST NOT be used in files containing only PHP.

### 2.5. Spaces

You MUST a single space after each comma delimiter.

You MUST add a single space around binary operators (==, &&, ...), with the exception of the concatenation (.)
operator.

You MUST place unary operators (!, --, ...) adjacent to the affected variable.

```php
if (isset($foo->bar) && $foo->bar > 0) {
   $foo->bar--;
}
```

### 2.6. Arrays

You MUST use brackets `[ ]` to create an array and not `array( )`.

You SHOULD place each subarray on a new line for multidimension arrays.

```php
$array = [
  ['red', 'blue', 'green'],
  ['big', 'small'],
  [22, 99]
];
```

### 2.7. Comparison

Loose comparison does loose casting with unexpected results. Similar to arithmetic operators (`+`/`-`/`*`/`/`/`**`/`%`),
loose comparison operators **should only** be used for numeric values. This is true for `==`, `!=`, `<`, `>`, `<=`,
`>=` and `<=>`.

For other types use strict comparion `===` and `!==` or type specific functions like `strcmp`.

### 2.8. Nested blocks

Within the body of a function or method, there SHOULD be no more than 3 levels of nesting. With this many levels of
nesting, introduce a new function rather than to use more nested blocks.

```php
function foo() {
    if (/* ... */) {
        foreach (/* ... */) {
            if (/* ... */) {
                // No more nested blocks
            }
        }
    }
}
```

### 2.9. Control flow

Assertions and alternative flows SHOULD come before the normal flow to reduce nesting.

**Examples of good flow:**

```php
function fizz($a) {
    if (!$a) {
        return;
    }

    foo();
    bar();
}
```

```php
function buzz($b) {
    while ($b as $i) {
        if (!$i) {
            continue;
        }
       
        $i->foo();
        $i->bar();
    }
}
```

**Examples of bad flow, with unnecessary nesting:**

```php
function fizz($a) {
    if ($a) {
        foo();
        bar();
    }
}
```

```php
function fizz($a) {
    if ($a) {
        foo();
    } else {
        return;
    }
    
    bar();
}
```

```php
function buzz($b) {
    while ($b as $i) {
        if ($i) {
            $i->foo();
            $i->bar();
        }
    }
}
```

## 3. Documentation

### 3.1. README

Each project MUST include a `README.md` document in the root folder.

The README document SHOULD include the title of and a short description the project.

The README document MAY include a list of prerequisites.

The README document SHOULD include installation instructions.

The README document SHOULD include API documentation or a link to the API documententation.

The README document MAY include additional information which can be useful for developers.

### 3.2. Document blocks

Each class MUST have a [document block](https://en.wikipedia.org/wiki/PHPDoc).

Each public property that doesn't have a type hint MUST have a document block with an `@var` tag. Each protected and
private property that doesn't have a type hint SHOULD have a document block with an `@var` tag.

Each function and method SHOULD have a document block with `@param` tags for all parameters and an `@return` tag if a
value is returned.

Variables document block SHOULD be as precise as possible. Examples:

 * `@return string|boolean|array` is preferred to `@var mixed`
 * `@var Foo|Bar` is preferred to `@var object`
 * `@var Foo[]` is preferred to `@var array`

A document block for a method that implements the [fluent interface pattern](https://en.wikipedia.org/wiki/Fluent_interface)
SHOULD state `@return $this`.

_Tests cases are an exception to this paragraph. See 4.4._


## 4. Testing

### 4.1. Unit tests
 
Applications and libraries SHOULD include unit tests, runnable by phpunit or codeception.

Each library class and function SHOULD be covered by unit tests, with a code coverage of 100%. Code that can't be
tested should be [explicitly ignored](https://phpunit.de/manual/current/en/code-coverage-analysis.html#code-coverage-analysis.ignoring-code-blocks).

Each model class SHOULD be covered by unit tests, with a code coverage of 95% or more.

A controller class SHOULD NOT be covered by unit tests.

### 4.2. API tests

Applications with a web service API SHOULD include API tests, runnable by codeception.

Controller methods related to a web service SHOULD be covered by API tests, with a code covereage of 95% or more.

### 4.3. Functional tests

Applications with a user interface SHOULD have a test plan for manual acceptance testing.

Controller methods not related to a web service MAY be covered by automated functional tests, runnable by codeception.

### 4.4. Documentation

Test cases SHOULD NOT use document blocks for all properties and methods as stated in 3.2.

Tests SHOULD use document blocks for annotations where available. Test cases SHOULD use annotations rather than code if
possible.

