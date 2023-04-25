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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sonata\SeoBundle\Block\Breadcrumb\HomepageBreadcrumbBlockService;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()

        ->set('sonata.seo.block.breadcrumb.homepage', HomepageBreadcrumbBlockService::class)
            ->public()
            ->tag('sonata.block')
            ->tag('sonata.breadcrumb')
            ->args([
                service('twig'),
                service('knp_menu.factory'),
            ]);
};
