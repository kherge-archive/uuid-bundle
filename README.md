UUID Bundle
===========

This bundle integrates [`ramsey/uuid`][] and [`ramsey/uuid-doctrine`][]
into Symfony 2 as configurable services. Support for Doctrine is not
required, but included with the bundle if `ramsey/uuid-doctrine` is
installed.

Installation
------------

Please use Composer to install the bundle.

    composer require kherge/uuid-bundle

Once Composer has downloaded the bundle and its dependencies, please
add the following like to where you believe it is appropriate in the
`AppKernel` class (or your app's equivalent).

    new KHerGe\Bundle\UuidBundle\KHerGeUuidBundle(),

Configuration
-------------

```yaml
kherge_uuid: ~
```

You can use `app/console config:dump-reference kherge_uuid` to see a
breakdown of all available settings. Each setting is documented so that
choosing the right settings becomes a little simpler.


### Recommended Settings

TBD

[`ramsey/uid`]: https://github.com/ramsey/uuid
[`ramsey/uid-doctrine`]: https://github.com/ramsey/uuid-doctrine
