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

use Sonata\SeoBundle\Event\BreadcrumbListener;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()

        ->set('sonata.seo.event.breadcrumb', BreadcrumbListener::class)
            ->tag('kernel.event_listener', [
                'event' => 'sonata.block.event.breadcrumb',
                'method' => 'onBlock',
            ]);
};
