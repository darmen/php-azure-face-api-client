# Microsoft Azure Face API PHP client

A PHP library that utilizes [Azure Cognitive Services REST API](https://docs.microsoft.com/en-us/rest/api/cognitiveservices/).

## Requirements

* PHP >= 7.1

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
$client->facelist()->create('test-id', 'test-name');
$client->largefacelist()->create('test-id-large', 'test-name-large');

$client->facelist()->get('test-id');
$client->largefacelist()->get('test-id-large');

$client->facelist()->delete('test-id');
$client->largefacelist()->delete('test-id-large');

// ...

```

Since the library wraps [Face API REST interface](https://docs.microsoft.com/en-us/rest/api/cognitiveservices/), feel free toe read the sources in `src/Resources` directory to find out more methods.

## Contribution

Happy to get your feedback, but also you are feel free to raise a pull request.

## License

This library is released under the MIT License.
