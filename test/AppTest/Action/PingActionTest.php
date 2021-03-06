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
namespace AppTest\Action;

use App\Action\PingAction;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PingActionTest extends TestCase
{
    /**
     * @return void
     */
    public function testResponse(): void
    {
        $pingAction = new PingAction();
        $response   = $pingAction->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            $this->prophesize(RequestHandlerInterface::class)->reveal()
        );

        $json = json_decode((string) $response->getBody());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(isset($json->ack));
    }
}
