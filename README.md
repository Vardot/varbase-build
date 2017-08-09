# Varbase Build

Moving varbase build of projects to https://github.com/Vardot/varbase-project

[![](https://docs.varbase.vardot.com/assets/Large-Logo%20Color%20with%20padding.png)](https://www.drupal.org/project/varbase)

[![Build Status](https://travis-ci.org/Vardot/varbase.svg?branch=8.x-4.06)](https://travis-ci.org/Vardot/varbase) Varbase 8.4.06

## Usage

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

> Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
You might need to replace `composer` with `php composer.phar` (or similar)
for your setup.

## After that you can create the project:

```
composer create-project Vardot/varbase-build:^8.4.06 PROJECT_DIR_NAME --no-dev --no-interaction
```

If you want to create a project with the development option, to get the latest
development work.

```
composer create-project Vardot/varbase-build:8.x PROJECT_DIR_NAME --stability dev --no-interaction
```

## [Create new Vartheme sub theme for a project](https://github.com/Vardot/varbase/tree/8.x-4.x/scripts/README.md)

## [Automated Functional Testing](https://github.com/Vardot/varbase/blob/8.x-4.x/tests/README.md)

## [Varbase Gherkin features](https://github.com/Vardot/varbase/blob/8.x-4.x/tests/features/varbase/README.md)

## [Varbase 8.4.x Developer Guide](https://docs.varbase.vardot.com)
