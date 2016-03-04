[![Build Status](https://travis-ci.org/kherge/uuid-bundle.svg?branch=master)](https://travis-ci.org/kherge/uuid-bundle)

UUID Bundle
===========

This bundle integrates [`ramsey/uuid`][1] into Symfony 2 as services.

Usage
-----

```php
use Ramsey\Uuid\Uuid;

// The UUID factory is available as a service.
$factory = $this->container->get('kherge_uuid.uuid_factory');

// And you can use it how you normally would.
$v1 = $factory->uuid1();
$v3 = $factory->uuid3(Uuid::NAMESPACE_DNS, 'example.com');
$v4 = $factory->uuid4();
$v5 = $factory->uuid5(Uuid::NAMESPACE_DNS, 'example.com');
```

Installation
------------

    composer require kherge/uuid-bundle

Once Composer has downloaded the bundle and its dependencies, please
add the following line to where you believe it is appropriate in the
`AppKernel` class (or your app's equivalent).

    new KHerGe\Bundle\UuidBundle\KHerGeUuidBundle(),

Configuration
-------------

While no configuration is required, you may want to refer to the output
of `app/console config:dump-reference kherge_uuid` to see a breakdown of
all available settings. Each setting is documented so that choosing the 
right settings becomes a little simpler. You will be expected to know
how to use the `ramsey/uuid` package to understand how the bundle's
settings will work with its classes.


### Recommended Settings

This will allow you to generate secure UUIDs, but requires that you
have the `moontoast/math` package and `libsodium` extension installed.

```yaml
kherge_uuid:
    builder:
        default:
            number_converter: kherge_uuid.number_converter.big_number
    generator:
        default_time:
            time_converter: kherge_uuid.time_converter.big_number
    uuid_factory:
        number_converter: kherge_uuid.number_converter.big_number
        random_generator: kherge_uuid.generator.sodium
        time_generator: kherge_uuid.generator.default_time
```

> You may want to change the random generator.

[1]: https://github.com/ramsey/uuid
[2]: https://github.com/ramsey/uuid-doctrine
