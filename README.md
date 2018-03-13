# HexanetSettingsBundle

Système de paramètres

## Installation

### Installation du bundle

Installer le bundle avec composer :

```bash
$ composer require hexanet/settings-bundle
```

### Activation

Il faut activer le bundle :

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

### Base de données

Il faut créer la table dans la base de données, pour ce faire on génére une migration :

```bash
php app/console doctrine:migrations:diff --filter-expression="/setting$/"
php app/console doctrine:migrations:migrate
```

## Utilisation

### Définir les paramètres

Un schéma permet d'initialiser les paramètres en leur donnant une valeur par défaut.

Il faut d'abord créer une classe qui étend de l'interface `SchemaInterface` :

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

Puis la déclarer en service avec le tag `hexanet.settings_schema` :

```yml
    app.settings_schema:
        class: Hexanet\Si\AppBundle\Settings\AppSchema
        tags: [hexanet.settings_schema]
```

Après on peut utiliser la commande `sf hexanet:settings:setup` pour générer tous les paramètres, si un paramètre existe déjà la commande l'ignore.

### Exemples d'utilisations

```php
$settingsManager = $this->get('hexanet.settings_manager');

// écriture puis récupération
$settingsManager->set('tva', 19.6);
$settingsManager->get('tva');

// vérifier si un paramètre existe
$settingsManager->has('tva');

// récupérer tous les paramètres
$settingsManager->all();

// récupérer un parmaètre qui n'existe pas
$settingsManager->get('pas là');
// une exception SettingNotFoundException est lancée
```

## Production

Pour la production il est possible d'activer le cache en modifiant la config du bundle :

```yaml
// app/config/config_prod.yml
hexanet_settings:
    cache: true
```

Le cache `app` de Symfony est utilisé (`@cache.app)`
