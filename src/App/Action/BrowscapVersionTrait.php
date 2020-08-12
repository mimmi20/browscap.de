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
namespace App\Action;

use Assert\Assert;
use PackageInfo\Package;

trait BrowscapVersionTrait
{
    /**
     * Converts a package number e.g. 1.2.3 into a "build number" e.g. 1002003
     *
     * There are three digits for each version, so 001002003 becomes 1002003 when cast to int to drop the leading zeros
     *
     * @throws \PackageInfo\Exception\PackageNotInstalledException
     *
     * @return int
     */
    private function getBrowscapVersion(): int
    {
        $package        = new Package('browscap/browscap');
        $packageVersion = $package->getVersion();

        Assert::that($packageVersion)->regex('#^(\d+\.)(\d+\.)(\d+)$#');

        return (int) sprintf('%03d%03d%03d', ...explode('.', $packageVersion));
    }
}
