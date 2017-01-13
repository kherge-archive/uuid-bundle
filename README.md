[![Build Status](https://travis-ci.org/kherge-php/uuid-bundle.svg?branch=master)](https://travis-ci.org/kherge-php/uuid-bundle)
[![Packagist](https://img.shields.io/packagist/v/kherge/uuid-bundle.svg)](https://packagist.org/packages/kherge/uuid-bundle)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/kherge/uuid-bundle.svg)](https://packagist.org/packages/kherge/uuid-bundle)

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

### Doctrine

You can have Doctrine automatically generate new UUIDs for your new
entities. Support is limited to only v1 and v4 UUIDs. To use the custom
generators, you will need to use the following annotations for the ID
field in your entity:

```php
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table()
 */
class Entity
{
    /**
     * @ORM\Column(type="uuid")
     * @ORM\CustomIdGenerator("KHerGe\Bundle\UuidBundle\Doctrine\Id\Uuid4Generator")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\Id()
     */
    private $id;
}
```

> Replace the class name with the desired generator.

It is strongly recommended that you enable the use of a global factory.
Not doing so will allow the UUID library to create and use its own UUID
factory, independent of the factory service that was configured for
Symfony.

```yaml
kherge_uuid:
    uuid_factory:
        global: true
```

### Parameter Conversion

The bundle provides support for converting UUIDs in request parameters. To use
this feature, you must have the `sensio/framework-extra-bundle` installed to
support parameter conversion.

```php
use Ramsey\Uuid\Uuid;

/**
 * @Route("/entity/{id}")
 * @ParamConverter("id")
 */
public function getAction(Uuid $id)
{
    // ... use the uuid ...
}
```

[1]: https://github.com/ramsey/uuid
[2]: https://github.com/ramsey/uuid-doctrine
