# Installation

This bundle can be installed using Composer. Tell composer to install the extension:

```bash
$ php composer.phar require prezent/feature-flag-bundle
```

Then, activate the bundle in your kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Prezent\GridBundle\PrezentFeatureFlagBundle(),
    );
}
```