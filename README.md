# PHP code quality

## Coding standard

Please read the [Jasny PHP coding standard](https://github.com/jasny/php-code-quality/blob/master/STANDARD.md#readme).


## Installation

All PHP projects of Legal Things should include this package. It can be installed through composer.

    composer require --dev jasny/php-code-quality

### Travis

Copy the Travis CI configuration file from the php-code-quality directory and enable the project on [Travis CI](http://travis-ci.org).

    cp vendor/jasny/php-code-quality/travis.yml.dist .travis.yml


## Toolchain

### PHPUnit
[PHPUnit](https://phpunit.de/) is a programmer-oriented testing framework for PHP. The unit tests should be in the `tests` directory.

    phpunit --configuration vendor/jasny/php-code-quality/phpunit.xml.dist

### vfsStream
[vfsStream](https://github.com/mikey179/vfsStream) is a stream wrapper for a virtual file system that may be helpful in unit tests to mock the real file system.

### PHP_CodeSniffer
[phpcs](https://github.com/squizlabs/PHP_CodeSniffer) tokenises PHP files and detects violations of a defined set of coding standards. It is an essential development tool that ensures your code remains clean and consistent.
This package comes with a custom ruleset which embodies the Jasny PHP coding standard.

    bin/phpcs . --standard=vendor/jasny/php-code-quality --ignore=/bin/,/vendor/,/bower_components/,/tests/

