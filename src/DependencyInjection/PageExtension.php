<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\PageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Zentlix\PageBundle\Domain\Menu\Service\PageMenuProvider;

class PageExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // MenuBundle support
        if (interface_exists('Zentlix\MenuBundle\Domain\Menu\Service\ProviderInterface')) {
            $container->registerForAutoconfiguration(PageMenuProvider::class)->addTag('zentlix.menu.provider');
        }

        $loader = new XmlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));

        $loader->load('bus.xml');
        $loader->load('controllers.xml');
        $loader->load('dashboard_widgets.xml');
        $loader->load('datatables.xml');
        $loader->load('form_types.xml');
        $loader->load('repositories.xml');
        $loader->load('services.xml');
        $loader->load('specifications.xml');
        $loader->load('subscribers.xml');
        $loader->load('twig_extensions.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('doctrine.yaml');
        $loader->load('twig.yaml');
    }
}