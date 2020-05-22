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

use Monolog\ErrorHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Container\ContainerInterface;

final class LoggerFactory
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     *
     * @return \Monolog\Logger
     */
    public function __invoke(ContainerInterface $container): Logger
    {
        $logger = new Logger('browscap');

        $stream = new StreamHandler('data/error.log', Logger::INFO);
        $stream->setFormatter(new LineFormatter('[%datetime%] %message% %extra%' . PHP_EOL));

        $memoryProcessor = new MemoryUsageProcessor(true);
        \assert(\is_callable($memoryProcessor));
        $logger->pushProcessor($memoryProcessor);

        $peakMemoryProcessor = new MemoryPeakUsageProcessor(true);
        \assert(\is_callable($peakMemoryProcessor));
        $logger->pushProcessor($peakMemoryProcessor);

        $logger->pushHandler($stream);
        $logger->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Logger::NOTICE));

        ErrorHandler::register($logger);

        return $logger;
    }
}
