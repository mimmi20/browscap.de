<?php
/**
 * This file is part of the mimmi20/browscap.de package.
 *
 * Copyright (c) 2015-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace App;

use BrowscapPHP\BrowscapInterface;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
final class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                Action\HomePageAction::class => Action\HomePageFactory::class,
                Action\DownloadsPageAction::class => Action\DownloadsPageFactory::class,
                Action\CapabilitiesPageAction::class => Action\CapabilitiesPageFactory::class,
                Action\LookupPageAction::class => Action\LookupPageFactory::class,
                LoggerInterface::class => LoggerFactory::class,
                Model\InputFilter\UaInputFilterInterface::class => Model\InputFilter\UaInputFilterFactory::class,
                Form\UaFormInterface::class => Form\UaFactory::class,
                BrowscapInterface::class => BrowscapFactory::class,
                StorageInterface::class => ZendCacheFactory::class,
                CacheInterface::class => Psr16CacheFactory::class,
                Action\PingAction::class => InvokableFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => ['templates/app'],
                'error' => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
