<?php
declare(strict_types = 1);
namespace App;

use BrowscapPHP\Browscap;
use Monolog\Logger;
use Psr\SimpleCache\CacheInterface;
use Zend\Cache\Storage\StorageInterface;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                Action\PingAction::class => Action\PingAction::class,
            ],
            'factories' => [
                Action\HomePageAction::class           => Action\HomePageFactory::class,
                Action\DownloadsPageAction::class      => Action\DownloadsPageFactory::class,
                Action\CapabilitiesPageAction::class   => Action\CapabilitiesPageFactory::class,
                Action\LookupResultAction::class       => Action\LookupResultFactory::class,
                Logger::class                          => LoggerFactory::class,
                Model\InputFilter\UaInputFilter::class => Model\InputFilter\UaInputFilterFactory::class,
                Form\UaForm::class                     => Form\UaFactory::class,
                Browscap::class                        => BrowscapFactory::class,
                StorageInterface::class                => ZendCacheFactory::class,
                CacheInterface::class                  => Psr16CacheFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
