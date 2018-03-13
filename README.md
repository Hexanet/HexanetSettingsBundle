# SettingsBundle

[![Build Status](https://api.travis-ci.org/Hexanet/HexanetSettingsBundle.svg)](http://travis-ci.org/Hexanet/HexanetSettingsBundle) 	[![Total Downloads](https://poser.pugx.org/hexanet/settings-bundle/downloads.png)](https://packagist.org/packages/hexanet/settings-bundle) [![Latest stable Version](https://poser.pugx.org/hexanet/settings-bundle/v/stable.png)](https://packagist.org/packages/hexanet/settings-bundle)

Settings system.

## Installation

Install the bundle with composer:

```bash
$ composer require hexanet/settings-bundle
```

### Activation

You have to activate the bundle:

```php
// in app/AppKernel.php
public function registerBundles() {
	$bundles = array(
		// ...
		new Hexanet\SettingsBundle\HexanetSettingsBundle(),
	);
	// ...
}
```

### Database

You have to create the table in the database, to do this we generate a migration:

```bash
php app/console doctrine:migrations:diff --filter-expression="/setting$/"
php app/console doctrine:migrations:migrate
```

## Usage

### Define the settings

A schema allows you to initialize the settings by giving them a default value.

First you need to create a class that extends from the `SchemaInterface` interface:

```php
<?php

namespace Hexanet\Si\AppBundle\Settings\AppSchema;

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
app.settings_schema:
    class: Hexanet\Si\AppBundle\Settings\AppSchema
    tags: [hexanet.settings_schema]
```

After that we can use the `sf hexanet:settings:setup` command to generate all the settings, if a setting already exists the command ignores it.

### Examples

```php
$settingsManager = $this->get('hexanet.settings_manager');

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
```

## Production

For production it's possible to activate the cache by modifying the config of the bundle:

```yaml
// app/config/config_prod.yml
hexanet_settings:
    cache: true
```

The Symfony cache `app` is used (`@cache.app)`

## Credits

Developed by [Hexanet](http://www.hexanet.fr/).

## License

[SettingsBundle](https://github.com/Hexanet/SettingsBundle) is licensed under the [MIT license](LICENSE).
