# PHP code quality

[![Build Status](https://travis-ci.org/jasny/php-code-quality.svg?branch=master)](https://travis-ci.org/jasny/php-code-quality)
[![Code Coverage](https://scrutinizer-ci.com/g/jasny/php-code-quality/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/jasny/php-code-quality/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jasny/php-code-quality/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jasny/php-code-quality/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/72d0ff50-daa3-4f2c-91ab-bf5c2397e899/mini.png)](https://insight.sensiolabs.com/projects/72d0ff50-daa3-4f2c-91ab-bf5c2397e899)


## Coding standard

The [Jasny PHP coding standard](https://github.com/jasny/php-code-quality/blob/master/STANDARD.md#readme) follows the
PSR-2 coding standard with a few additions.


## Installation

All PHP projects of Legal Things should include this package. It can be installed through composer.

    composer require --dev jasny/php-code-quality


## Toolchain

### PHPUnit
[PHPUnit](https://phpunit.de/) is a programmer-oriented testing framework for PHP. The unit tests should be in the
`tests` directory.

Copy the PHPUnit configuration into the projects root folder

    cp vendor/jasny/php-code-quality/phpunit.xml.dist .

#### vfsStream
[vfsStream](https://github.com/mikey179/vfsStream) is a stream wrapper for a virtual file system that may be helpful
in unit tests to mock the real file system.

### Codeception (optional)
[Codeception](http://codeception.com/) is a BDD style testing frameworks for PHP. It can be used for unit, functional
and integration tests.

The [Codeception module for Jasny MVC](https://github.com/jasny/codeception-module) allows you to run tests for
applications that use Jasny MVC.

Codeception isn't installed by default. It can be installed through composer.

    composer require --dev codeception/codeception jasny/codeception-module

### PHP CodeSniffer
[phpcs](https://github.com/squizlabs/PHP_CodeSniffer) tokenises PHP files and detects violations of a defined set of
coding standards. It is an essential development tool that ensures your code remains clean and consistent.

This package comes with a custom ruleset which embodies the Jasny PHP coding standard, which should be copied to the
project root folder.

    cp vendor/jasny/php-code-quality/phpcs.xml.dist phpcs.xml

### PHPStan
[PHPStan](https://github.com/phpstan/phpstan) is a static code analysis tool. It moves PHP closer to compiled languages
in the sense that the correctness of each line of the code can be checked before you run the actual line.

Copy the PHPStan configuration to the project root folder

    cp vendor/jasny/php-code-quality/phpstan.neon.dist phpstan.neon

### Composer scripts
Composer can be configured to run all tests

    "scripts": {
        "test": [
            "phpunit",
            "phpcs -p",
            "phpstan analyse"
        ]
    },
    "scripts-descriptions": {
        "test": "Run all tests and quality checks"
    }

To run all tests do

    composer run-script test

## Services

Open source projects should all of these quality assurance services. Closed source project may use a single service
to both run tests and code quality checks in order to save costs.

### Travis
[Travis CI](https://travis-ci.org) will run all unit tests on each pull-request and push to the master branch.

Copy the Travis CI configuration file from the php-code-quality directory.

    cp vendor/jasny/php-code-quality/travis.yml.dist .travis.yml

### Scrutinizer
[Scrutinizer](https://scrutinizer-ci.com/) tests code quality using PHP CodeSniffer, PHPStan and a custom analysis
tool from Scrutinizer. It also collects tests coverage results from Travis CI.

### SensioLabsInsight
[SensioLabsInsight](https://insight.sensiolabs.com) gives automatic and unique advise for increasing code quality.

### Better Code Hub
[Better Code Hub](https://bettercodehub.com) checks the source code against 10 guidelines.

Copy the Better Code Hub configuration file into the project root directory.

    cp vendor/jasny/php-code-quality/bettercodehub.yml.dist .bettercodehub.yml

