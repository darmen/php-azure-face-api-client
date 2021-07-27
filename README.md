# Microsoft Azure Face API PHP client

A PHP library that utilizes [Azure Face REST API](https://docs.microsoft.com/en-us/rest/api/face/).

[![Build status](https://github.com/darmen/php-azure-face-api-client/workflows/Tests/badge.svg)](https://github.com/darmen/php-azure-face-api-client/actions)
[![Latest Stable Version](http://poser.pugx.org/darmen/php-azure-face-api-client/v/stable)](https://packagist.org/packages/darmen/php-azure-face-api-client)
[![Total Downloads](http://poser.pugx.org/darmen/php-azure-face-api-client/downloads)](https://packagist.org/packages/darmen/php-azure-face-api-client)

## Requirements

* PHP >= 7.4

## Installation

```bash
composer require darmen/php-azure-face-api-client
```

Use the autoloader in your projects:

```php
require 'vendor/autoload.php';
```

## Future plans
- [ ] Face resource 
- [x] Face List resource
- [x] Large Face List resource
- [ ] Large Person Group resource 
- [ ] Large Person Group Person resource 
- [ ] Person Group resource 
- [ ] Person Group Person resource 
- [ ] Snapshot resource 

## Usage

All following examples assume this step.

```php
use Darmen\AzureFace\Client;

$client = new Client('<endpoint>', '<subscription key>');
```

### Working with resources
```php
$client->faceList()->create('test-id', 'test-name');
$client->largeFaceList()->create('test-id-large', 'test-name-large');

$client->faceList()->get('test-id');
$client->largeFaceList()->get('test-id-large');

$client->faceList()->delete('test-id');
$client->largeFaceList()->delete('test-id-large');

// ...

```

Since the library wraps [Face API REST interface](https://docs.microsoft.com/en-us/rest/api/face/), feel free toe read the sources in `src/Resources` directory to find out more methods.

## Contribution

Happy to get your feedback, but also you are feel free to raise a pull request.

## License

This library is released under the MIT License.
