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

use Sonata\Exporter\Source\DoctrineDBALConnectionSourceIterator;
use Sonata\Exporter\Source\SymfonySitemapSourceIterator;
use Sonata\SeoBundle\Seo\SeoPage;
use Sonata\SeoBundle\Sitemap\SourceManager;
use Sonata\SeoBundle\Twig\Extension\SeoExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // Use "service" function for creating references to services when dropping support for Symfony 4.4
    // Use "param" function for creating references to parameters when dropping support for Symfony 5.1
    $containerConfigurator->parameters()

        ->set('sonata.seo.exporter.database_source_iterator.class', DoctrineDBALConnectionSourceIterator::class)

        ->set('sonata.seo.exporter.sitemap_source_iterator.class', SymfonySitemapSourceIterator::class)

        ->set('sonata.seo.page.default.class', SeoPage::class)

        ->set('sonata.seo.twig.extension.class', SeoExtension::class)

        ->set('sonata.seo.sitemap.manager.class', SourceManager::class);

    $containerConfigurator->services()

        ->set('sonata.seo.page.default', '%sonata.seo.page.default.class%')
            ->public()

        ->set('sonata.seo.twig.extension', '%sonata.seo.twig.extension.class%')
            ->tag('twig.extension')
            ->args([
                new ReferenceConfigurator('sonata.seo.page'),
                '',
            ])

        ->set('sonata.seo.sitemap.manager', '%sonata.seo.sitemap.manager.class%')
            ->public();
};
