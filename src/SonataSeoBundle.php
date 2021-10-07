<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle;

use Sonata\SeoBundle\DependencyInjection\Compiler\BreadcrumbBlockServicesCompilerPass;
use Sonata\SeoBundle\DependencyInjection\Compiler\ServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SonataSeoBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new BreadcrumbBlockServicesCompilerPass());
        $container->addCompilerPass(new ServiceCompilerPass());
    }
}
