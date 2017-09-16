# PhpMob Omise - WIP NOT RELEASE YET!
[![License](https://poser.pugx.org/phpmob/omise/license)](https://packagist.org/packages/phpmob/omise)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/phpmob/omise/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phpmob/omise/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/phpmob/omise/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/phpmob/omise/?branch=master)
[![Build Status](https://travis-ci.org/phpmob/omise.svg?branch=master)](https://travis-ci.org/phpmob/omise)
[![Latest Stable Version](https://poser.pugx.org/phpmob/omise/version)](https://packagist.org/packages/phpmob/omise)
[![Latest Unstable Version](https://poser.pugx.org/phpmob/omise/v/unstable)](//packagist.org/packages/phpmob/omise)

Just alternative Omise api client - in php.

## Installation
Install via composer.

```bash
$ composer require phpmob/omise
```

To use [guzzlehttp/guzzle](https://github.com/guzzle/guzzle) you need to install it's adapter. Thanks [httplug](https://github.com/php-http/httplug).

```bash
$ composer require php-http/guzzle6-adapter
```

Now you can use built-in `\PhpMob\Omise\Client\GuzzleHttpClient`.

## Usage
A [phpmob/omise](https://github.com/phpmob/omise) desinged for `Solid` use and also add bonus for Static big fan use by implementing `Facade`.

#### Solid Usage

```php
<?php

use PhpMob\Omise\Api\Charge as ChargeApi;
use PhpMob\Omise\Api\Token as TokenApi;
use PhpMob\Omise\Domain\Card;
use PhpMob\Omise\Domain\Charge;
use PhpMob\Omise\Domain\Token;
use PhpMob\Omise\OmiseApi;
use PhpMob\Omise\Client\GuzzleHttpClient;

$client = new GuzzleHttpClient();
$options = [
    'secret_key' => 'secretKey',
    'public_key' => 'publicKey',
    'sandbox' => true, // livemode?
];

$api = new OmiseApi($client, $options);

/** @var TokenApi $tokenApi */
$tokenApi = $api->create(TokenApi::class);

// create token
$token = new Token();
$token->card = new Card();
$token->card->name = 'Somchai Prasert';
$token->card->number = '4242424242424242';
$token->card->city = 'Bangkok';
$token->card->postalCode = '10320';
$token->card->expirationMonth = 10;
$token->card->expirationYear = 2018;
$token->card->securityCode = 123;

$tokenApi->create($token);

/** @var ChargeApi $chargeApi */
$chargeApi = $api->create(ChargeApi::class);

// find single
$charge = $chargeApi->find('charge_id');
echo $charge->id;

// find all
$charges = $chargeApi->all();

// Create charge
$charge = new Charge();
$charge->amount = 10000;
$charge->currency = 'thb';
$charge->cardToken = $token->id;

$chargeApi->create($charge);

```

#### Static Usage

```php
<?php

use PhpMob\Omise\Facade\Card;
use PhpMob\Omise\Facade\Charge;
use PhpMob\Omise\Facade\Token;
use PhpMob\Omise\OmiseApi;
use PhpMob\Omise\Client\GuzzleHttpClient;

$client = new GuzzleHttpClient();
$options = [
    'secret_key' => 'secretKey',
    'public_key' => 'publicKey',
    'sandbox' => true, // livemode?
];

OmiseApi::setupFacade($client, $options);

// create token
$token = Token::make();
$token->card = Card::make();
$token->card->name = 'Somchai Prasert';
$token->card->number = '4242424242424242';
$token->card->city = 'Bangkok';
$token->card->postalCode = '10320';
$token->card->expirationMonth = 10;
$token->card->expirationYear = 2018;
$token->card->securityCode = 123;

$token->create();

// find single charge
$charge = Charge::find('charge_id');
echo $charge->id;

// find all
$charges = Charge::all();

// Create charge
$charge = Charge::make();
$charge->amount = 10000;
$charge->currency = 'thb';
$charge->cardToken = $token->id;

$charge->create();

```

#### Error handling.
A [phpmob/omise](https://github.com/phpmob/omise) provide two type of Error handling.

  - **InvalidRequestArgumentException** When you need to capture error before sending request.
  - **InvalidResponseException** When you need to capture error responded from api.

```php
<?php

use PhpMob\Omise\Exception\InvalidResponseException;
use PhpMob\Omise\Facade\Charge;

try {
    // Create charge
    $charge = Charge::make();
    $charge->amount = 10000;
    $charge->currency = 'thb';
    $charge->cardToken = 'token_id';
    
    $charge->create();
} catch (InvalidResponseException $e) {
    echo $e->error->message;
}

```

## Contributing
Would like to help us and build the developer-friendly php code? Just follow our [Coding Standards](#coding-standards) and test your code — see [tests](tests),  [spec](spec).

Let Fork and PR now!

## Coding Standards

When contributing code to PhpMob, you must follow its coding standards.

PhpMob follows the standards defined in the [PSR-0](http://www.php-fig.org/psr/psr-0/), [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) documents.

## TODOs Testing
  - [ ] Writing spec tests.
  - [ ] Writing unit tests.
  - [ ] Add support PHP 5.6?

## Tests
```bash
$ ./bin/phpspec run -fpretty
$ ./bin/phpunit
```

## LICENSE
[MIT](LICENSE)
