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

namespace Sonata\SeoBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

/**
 * @final since sonata-project/seo-bundle 2.x
 */
class ConfigurationTest extends TestCase
{
    public function testDefaultConfiguration()
    {
        $expected = [
            'encoding' => 'UTF-8',
            'page' => [
                'default' => 'sonata.seo.page.default',
                'head' => [],
                'metas' => [],
                'separator' => ' - ',
                'title' => 'Project name',
            ],
            'sitemap' => [
                'doctrine_orm' => [],
                'services' => [],
            ],
            'http' => [
                'client' => null,
                'message_factory' => null,
            ],
        ];

        $this->assertSame($expected, $this->processConfiguration([[]]));
    }

    public function testKeysAreNotNormalized()
    {
        $values = [
            'page' => [
                'head' => ['data-example' => 'abc-123'],
                'metas' => [
                    'http-equiv' => [
                        'Content-Type' => 'text/html; charset=utf-8',
                    ],
                ],
            ],
        ];

        $config = $this->processConfiguration([$values]);

        $expected = array_merge_recursive(
            $this->getDefaultConfiguration(),
            $values
        );

        $this->assertSame($expected, $config);
    }

    public function testWithYamlConfig()
    {
        $values = Yaml::parse(
            file_get_contents(__DIR__.'/data/config.yml'),
            Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE
        );

        $config = $this->processConfiguration([$values]);

        $expected = array_merge_recursive(
            $this->getDefaultConfiguration(),
            $values
        );

        $this->assertSame($expected, $config);

        $this->assertSame('website', $config['page']['metas']['property']['og:type']);
    }

    private function getDefaultConfiguration()
    {
        return [
            'page' => [
                'head' => [],
                'metas' => [],
                'default' => 'sonata.seo.page.default',
                'separator' => ' - ',
                'title' => 'Project name',
            ],
            'encoding' => 'UTF-8',
            'sitemap' => [
                'doctrine_orm' => [],
                'services' => [],
            ],
            'http' => [
                'client' => null,
                'message_factory' => null,
            ],
        ];
    }

    private function processConfiguration(array $configs)
    {
        $configuration = new Configuration();
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }
}
