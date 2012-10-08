<?php

/*
 * This file is part of the RuudkMoneybirdBundle package.
 *
 * (c) Ruud Kamphuis <ruudk@mphuis.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ruudk\MoneybirdBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class RuudkMoneybirdExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (isset($config['subdomain'])) {
            $container->setParameter('ruudk_moneybird.subdomain', $config['subdomain']);
        }

        if (isset($config['username'])) {
            $container->setParameter('ruudk_moneybird.username', $config['username']);
        }

        if (isset($config['password'])) {
            $container->setParameter('ruudk_moneybird.password', $config['password']);
        }
    }
}
