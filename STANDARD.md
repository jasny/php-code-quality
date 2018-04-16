# Jasny PHP coding standard

This guide defines a set of rules aimed to create consistent code across all PHP projects of Jasny.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and
"OPTIONAL" in this document are to be interpreted as described in RFC 2119.

The term Application is used for deliverables that are typically served by a web server or run on the command line. The
term Library is used for a collection of classes and/or functions which is consumed by projects or other libraries.


## 1. PSR-1

Jasny follows the [PSR-1 basic coding standard](http://www.php-fig.org/psr/psr-1/) with an exception on [Section 3 - Namespace and Class Names](3.-namespace-and-class-names).

Applications SHOULD NOT use a vendor namespace.


## 2. PSR-2

Jasny follows the [PSR-2 coding style guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

### 2.1. Exception on [Section 2.3 - Lines](http://www.php-fig.org/psr/psr-2/#2.3.-lines)

The following rule may be ignored:

> ~~Lines SHOULD NOT be longer than 80 characters; lines longer than that SHOULD be split into multiple subsequent lines of no more than 80 characters each.~~


## 3. Structure

### 3.1. Keywords

The keywords `AND` and `OR` SHOULD NOT be used. Instead use `&&` and `||`.

### 3.2. File length

PHP files SHOULD be 500 lines or less.

### 3.3. Function length

Functions and methods SHOULD be 30 lines or less.

### 3.4. Alternative syntax for control structures

The [alternative syntax for control structures](http://php.net/manual/en/control-structures.alternative-syntax.php)
MUST NOT be used in files containing only PHP.

### 3.5. Spaces

You MUST a single space after each comma delimiter.

You MUST add a single space around binary operators (==, &&, ...), with the exception of the concatenation (.)
operator.

You MUST place unary operators (!, --, ...) adjacent to the affected variable.

```php
if (isset($foo->bar) && $foo->bar > 0) {
   $foo->bar--;
}
```

### 3.6. Arrays

You MUST use brackets `[ ]` to create an array.

You MUST place each subarray on a new line for multidimension arrays.

```php
$array = [
  ['red', 'blue', 'green'],
  ['big', 'small'],
  [22, 99]
];
```

### 3.6. Instantiating objects

Use parentheses when instantiating classes regardless of the number of arguments the constructor has.

```
$foo = new Foo();
```

### 3.7. Comparison

Always use [identical comparison](http://php.net/manual/en/language.operators.comparison.php). If needed explicitly
cast values to a specific type (eg `(string)$foo === $bar)`).

Always use variable operator value (eg `$foo >= 10`) and never yoda coditions.

Use `return null;` when a function explicitly returns null values and use `return;` when the function returns void
values.


### 3.8. Nested blocks

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

### 3.9. Control flow

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

## 3.10. Classes

Properties and methods SHOULD NOT be private, only public or protected.

Classes SHOULD NOT have simple getter and setter functions as replacement for public properties.


## 4. Documentation

### 4.1. README

Each project MUST include a `README.md` document in the root folder.

The README document SHOULD include the title of and a short description the project.

The README document SHOULD include a list of prerequisites.

The README document SHOULD include installation instructions.

The README document SHOULD include API documentation or a link to the API documententation.

The README document MAY include additional information which can be useful for developers.

### 4.2. Document blocks

Each class MUST have a [document block](https://en.wikipedia.org/wiki/PHPDoc).

Each public property MUST have a document block with an `@var` tag. Each protected of private property SHOULD have a
document block with an `@var` tag.

Each function and method MUST have a document block with `@param` tags for all parameters and an `@return` tag if a
value is returned.

Variables document block SHOULD be as precise as possible. Examples:

 * `@return string|boolean|array` is preferred to `@var mixed`
 * `@var Foo|Bar` is preferred to `@var object`
 * `@var Foo[]` is preferred to `@var array`

A document block for a method that implements the [fluent interface pattern](https://en.wikipedia.org/wiki/Fluent_interface)
SHOULD state `@return $this`.

_Tests cases are an exception to this paragraph. See 5.4._


## 5. Testing

### 5.1. Unit tests
 
Applications and libraries SHOULD include unit tests, runnable by phpunit or codeception.

Each library class and function SHOULD be covered by unit tests, with a code coverage of 100%. Code that can't be
tested should be [explicitly ignored](https://phpunit.de/manual/current/en/code-coverage-analysis.html#code-coverage-analysis.ignoring-code-blocks).

Each model class SHOULD be covered by unit tests, with a code coverage of 95% or more.

A controller class SHOULD NOT be covered by unit tests.

### 5.2. API tests

Applications with a web service API SHOULD include API tests, runnable by codeception.

Controller methods related to a web service SHOULD be covered by API tests, with a code covereage of 95% or more.

### 5.3. Functional tests

Applications with a user interface SHOULD have a test plan for manual acceptance testing.

Controller methods not related to a web service MAY be covered by automated functional tests, runnable by codeception.

### 5.4. Documentation

Test cases SHOULD NOT use document blocks for all properties and methods as stated in 4.2.

Tests SHOULD use document blocks for annotations where available. Test cases SHOULD use annotations rather than code if
possible.

### 5.5. Continuous integration

The default branch (typically `master`) SHOULD be protected. You SHOULD NOT push directly to the default branch.

Pull requests SHOULD be tested by running the unit tests on an continuous integration platform (like Travis CI or
Scrutinizer) prior to being merged with the default branch.

Pull requests SHOULD be tested on code quality (using eg Scrutinizer) prior to being merged with the default branch.


## 6. License

Open source Jasny libraries SHOULD be released under the MIT license. A `LICENSE` file SHOULD be present in the library's
root folder.

