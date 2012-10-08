RuudkMoneybirdBundle
====================

A Symfony2 bundle for working with Moneybird

This bundle uses the official [Moneybird PHP API](https://github.com/bluetools/moneybird_php_api) created by Sjors van der Pluijm.

## Installation

### Step1: Require the package with Composer

``php composer.phar require ruudk/moneybird-bundle``

### Step2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Ruudk\MoneybirdBundle\RuudkMoneybirdBundle(),
    );
}
```

### Step3: Configure

Finally, add the following to your config.yml

``` yaml
# app/config/config_prod.yml

ruudk_moneybird:
    subdomain: # Subdomain
    username: # Username
    password: # Password
```

Congratulations! You're ready.

## Use the API

````php
$moneybird = $this->container->get('moneybird.api');

$contactService = $moneybird->getService('Contact');

$contacts = $contactService->getAll();
foreach($contacts AS $contact) {
    echo $contact->name . "<br>";
}
````

For full usage of the Moneybird API see the [documentation](https://github.com/bluetools/moneybird_php_api/wiki/Examples).

## Commands

If you want to reset your Moneybird account and delete all invoices and contacts you can run:

``php app/console moneybird:reset``