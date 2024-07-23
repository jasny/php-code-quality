# PHP code quality

## Coding standard

Adhere to the [PSR-12 coding standard](https://www.php-fig.org/psr/psr-12/).


## Installation

All PHP projects of Jasny should include this package. It can be installed through composer.

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
            "phpstan analyse",
            "phpcs -p src"
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

### GitHub actions
[GitHub actions](https://github.com/features/actions) will run all unit tests on each pull-request and push to the master branch.

Copy the `github` folder from the php-code-quality directory.

    cp -r vendor/jasny/php-code-quality/github .github

### Scrutinizer
[Scrutinizer](https://scrutinizer-ci.com/) tests code quality using PHP CodeSniffer, PHPStan and a custom analysis
tool from Scrutinizer. It also collects tests coverage results.

