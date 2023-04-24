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

use Sonata\SeoBundle\Seo\SeoPage;
use Sonata\SeoBundle\Sitemap\SourceManager;
use Sonata\SeoBundle\Twig\Extension\SeoExtension;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()

        ->set('sonata.seo.page.default', SeoPage::class)
            ->public()

        ->set('sonata.seo.twig.extension', SeoExtension::class)
            ->tag('twig.extension')
            ->args([
                service('sonata.seo.page'),
                abstract_arg('encoding'),
            ])

        ->set('sonata.seo.sitemap.manager', SourceManager::class);
};
