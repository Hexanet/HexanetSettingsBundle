# SettingsBundle

[![Build Status](https://api.travis-ci.org/Hexanet/SettingsBundle.svg)](http://travis-ci.org/Hexanet/SettingsBundle) 	[![Total Downloads](https://poser.pugx.org/hexanet/settings-bundle/downloads.png)](https://packagist.org/packages/hexanet/settings-bundle) [![Latest stable Version](https://poser.pugx.org/hexanet/settings-bundle/v/stable.png)](https://packagist.org/packages/hexanet/settings-bundle)

Settings system.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require hexanet/settings-bundle
```

### Applications that don't use Symfony Flex

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require hexanet/settings-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Hexanet\SettingsBundle\HexanetSettingsBundle(),
        );

        // ...
    }

    // ...
}
```

### Database

You have to create the table in the database, to do this we generate a migration:

```bash
bin/console doctrine:migrations:diff --filter-expression="/setting$/"
bin/console doctrine:migrations:migrate
```

## Usage

### Define the settings

A schema allows you to initialize the settings by giving them a default value.

First you need to create a class that extends from the `SchemaInterface` interface:

```php
<?php

namespace App\Settings\AppSchema;

use Hexanet\SettingsBundle\Schema\SettingsBuilder;
use Hexanet\SettingsBundle\Schema\SchemaInterface;

class AppSchema implements SchemaInterface
{
    public function build(SettingsBuilder $settingsBuilder): void
    {
        $settingsBuilder->addSetting('itemsPerPage', 25);
    }
}
```

Then declare it as service with the `hexanet.settings_schema` tag :

```yml
App\Settings\AppSchema:
    tags: [hexanet.settings_schema]
```

> The bundle provide autoconfiguration for class that implement `SchemaInterface`.

After that we can use the `php bin/console hexanet:settings:setup` command to generate all the settings, if a setting already exists the command ignores it.

### Examples

```php
public function indexAction(SettinsManagerInterface $settingsManager) {
    // set and get
    $settingsManager->set('tva', 19.6);
    $settingsManager->get('tva');

    // check if settign exists
    $settingsManager->has('tva');

    // get all settings
    $settingsManager->all();

    // retrieve a non-existent setting 
    $settingsManager->get('not here');
    //  SettingNotFoundException is throw
}
```

## Production

For production it's possible to activate the cache by modifying the config of the bundle:

```yaml
// config/packages/prod/hexanet_settings.yaml
hexanet_settings:
    cache: true
```

The Symfony cache `app` is used (`@cache.app)`

## Credits

Developed by [Hexanet](http://www.hexanet.fr/).

## License

[SettingsBundle](https://github.com/Hexanet/SettingsBundle) is licensed under the [MIT license](LICENSE).
