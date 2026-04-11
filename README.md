# CanMakeOrFake

[![Latest Version on Packagist](https://img.shields.io/packagist/v/settleup/can-make-or-fake.svg?style=flat-square)](https://packagist.org/packages/settleup/can-make-or-fake)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/trysettleup/can-make-or-fake/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/trysettleup/can-make-or-fake/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/settleup/can-make-or-fake.svg?style=flat-square)](https://packagist.org/packages/settleup/can-make-or-fake)

A lightweight Laravel trait that gives any class a `make()` static constructor (resolved through the container) and a `fake()` method for easy test mocking.

## Installation

```bash
composer require settleup/can-make-or-fake
```

## Usage

Add the `CanMakeOrFake` trait to any class:

```php
use SettleUp\CanMakeOrFake\CanMakeOrFake;

class PriceCalculator
{
    use CanMakeOrFake;

    public function calculate(int $quantity, int $unitPrice): int
    {
        return $quantity * $unitPrice;
    }
}
```

### Resolving instances with `make()`

`make()` resolves the class through Laravel's service container, so any constructor dependencies are automatically injected:

```php
$calculator = PriceCalculator::make();

$total = $calculator->calculate(quantity: 3, unitPrice: 500); // 1500
```

### Faking in tests with `fake()`

`fake()` creates a Mockery partial mock and binds it into the container. Any subsequent call to `make()` (or container resolution) will return the mock:

```php
use Mockery\MockInterface;

PriceCalculator::fake(function (MockInterface $mock) {
    $mock->shouldReceive('calculate')->andReturn(0);
});

// Anywhere in your application that resolves PriceCalculator will now get the fake
$calculator = PriceCalculator::make();
$calculator->calculate(3, 500); // 0
```

Because `fake()` creates a partial mock, any methods you don't explicitly mock will still call the real implementation.

### Conditionable

The trait includes Laravel's `Conditionable` trait, so you can use `when()` and `unless()`:

```php
$calculator = PriceCalculator::make();

$calculator->when($applyDiscount, function (PriceCalculator $calc) {
    // ...
});
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrew Leach](https://github.com/andyleach)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
