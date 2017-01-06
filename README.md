# Intacct SDK for PHP

[![Build Status](https://travis-ci.org/Intacct/intacct-sdk-php.svg?branch=master)](https://travis-ci.org/Intacct/intacct-sdk-php)

If you would like to get involved please fork the repository and submit a pull request.

## Resources

* [Intacct][intacct] - Intacct's home page
* [Issues][sdk-issues] - Report issues with the SDK or submit pull requests
* [License][sdk-license] - Apache 2.0 license

## System Requirements

* You must have an active Intacct Web Services Developer license
* PHP >= 5.6
* A recent version of cURL >= 7.19.4 compiled with OpenSSL and zlib

## Installation

Install [Composer][composer]:

```bash
curl -sS https://getcomposer.org/installer | php
```

Specify the Intacct SDK for PHP as a dependency in your project's composer.json file:

```json
{
    "require": {
        "intacct/intacct-sdk-php": "v1.*"
    }
}
```

After installing, you need to require Composer's autoloader in your project file(s):

```php
require __DIR__ . '/vendor/autoload.php';
```

## Examples

### Create an Intacct Client

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use Intacct\IntacctClient;

try {
    $client = new IntacctClient();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

[intacct]: http://www.intacct.com
[sdk-issues]: https://github.com/Intacct/intacct-sdk-php/issues
[sdk-license]: http://www.apache.org/licenses/LICENSE-2.0
[composer]: https://getcomposer.org/
[packagist]: https://packagist.org/packages/intacct/intacct-sdk-php
