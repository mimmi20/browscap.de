<?php
/**
 * Script for clearing the configuration cache.
 *
 * Can also be invoked as `composer clear-config-cache`.
 *
 * @see       https://github.com/zendframework/zend-expressive-skeleton for the canonical source repository
 * @copyright Copyright (c) 2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-expressive-skeleton/blob/master/LICENSE.md New BSD License
 */

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

$config = include 'config/config.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

try {
    /** @var \Psr\SimpleCache\CacheInterface $cache */
    $cache = $container->get(\Psr\SimpleCache\CacheInterface::class);
} catch (\Psr\Container\NotFoundExceptionInterface $e) {
    var_dump($e);
    exit(1);
} catch (\Psr\Container\ContainerExceptionInterface $e) {
    var_dump($e);
    exit(1);
}

try {
    /** @var \Monolog\Logger $logger */
    $logger = $container->get(\Monolog\Logger::class);
} catch (\Psr\Container\NotFoundExceptionInterface $e) {
    var_dump($e);
    exit(1);
} catch (\Psr\Container\ContainerExceptionInterface $e) {
    var_dump($e);
    exit(1);
}

$browscap = new \BrowscapPHP\BrowscapUpdater($cache, $logger);
try {
    $browscap->update(\BrowscapPHP\Helper\IniLoaderInterface::PHP_INI_FULL);
} catch (\BrowscapPHP\Exception\FileNotFoundException $e) {
    var_dump($e);
    exit(1);
} catch (\BrowscapPHP\Helper\Exception $e) {
    var_dump($e);
    exit(1);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e);
    exit(1);
}

exit(0);
