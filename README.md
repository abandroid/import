Import
======

*By [endroid](https://endroid.nl/)*

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/import.svg)](https://packagist.org/packages/endroid/import)
[![Build Status](http://img.shields.io/travis/endroid/Import.svg)](http://travis-ci.org/endroid/Import)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/import.svg)](https://packagist.org/packages/endroid/import)
[![Monthly Downloads](http://img.shields.io/packagist/dm/endroid/import.svg)](https://packagist.org/packages/endroid/import)
[![License](http://img.shields.io/packagist/l/endroid/import.svg)](https://packagist.org/packages/endroid/import)

This library helps you building an import.

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require endroid/import
```

## Symfony integration

Register the Symfony bundle in the kernel.

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Endroid\Import\Bundle\EndroidImportBundle(),
    ];
}
```

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatibility
breaking changes will be kept to a minimum but be aware that these can occur.
Lock your dependencies for production and test your code when upgrading.

## License

This bundle is under the MIT license. For the full copyright and license
information please view the LICENSE file that was distributed with this source code.
