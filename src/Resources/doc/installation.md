# Installation

This bundle can be installed using Composer. Tell composer to install the extension:

```bash
$ php composer.phar require prezent/feature-flag-bundle
```

Then, activate the bundle (Symfony 4+):

```php
<?php
// config/bundles.php

return [
    // ...
    Prezent\FeatureFlagBundle\PrezentFeatureFlagBundle::class => ['all' => true],
];
```

or (Symfony 3):

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Prezent\FeatureFlagBundle\PrezentFeatureFlagBundle(),
    ];
}
```

# Configuration

## Full example
```yml
prezent_feature_flag:
    default_permission: false #default value for an undefinded permission
    handler: Prezent\FeatureFlagBundle\Handler\ConfigHandler # the handler to use
```

# Defining Feature Flags

## Via config
If you define your feature flags in a config file, prefix the name of the flags with ```ff_```

```yml
parameters:
    ff_myfeature: true
```

## Via Doctrine
Define your feature flags in the database, using the provider entity and migration
