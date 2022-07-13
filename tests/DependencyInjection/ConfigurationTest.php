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

final class ConfigurationTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        $expected = [
            'encoding' => 'UTF-8',
            'page' => [
                'default' => 'sonata.seo.page.default',
                'head' => [],
                'metas' => [],
                'separator' => ' - ',
                'title' => '',
                'title_prefix' => null,
                'title_suffix' => null,
            ],
            'sitemap' => [
                'doctrine_orm' => [],
                'services' => [],
            ],
        ];

        static::assertSame($expected, $this->processConfiguration([[]]));
    }

    public function testKeysAreNotNormalized(): void
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

        static::assertSame($expected, $config);
    }

    public function testWithYamlConfig(): void
    {
        $values = Yaml::parse(
            /* @phpstan-ignore-next-line */
            file_get_contents(__DIR__.'/data/config.yml'),
            Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE
        );

        $config = $this->processConfiguration([$values]);

        $expected = array_merge_recursive(
            $this->getDefaultConfiguration(),
            $values
        );

        static::assertSame($expected, $config);

        static::assertSame('website', $config['page']['metas']['property']['og:type']);
    }

    /**
     * @return array<string, mixed>
     */
    private function getDefaultConfiguration(): array
    {
        return [
            'page' => [
                'head' => [],
                'metas' => [],
                'default' => 'sonata.seo.page.default',
                'separator' => ' - ',
                'title' => '',
                'title_prefix' => null,
                'title_suffix' => null,
            ],
            'encoding' => 'UTF-8',
            'sitemap' => [
                'doctrine_orm' => [],
                'services' => [],
            ],
        ];
    }

    /**
     * @param mixed[] $configs
     *
     * @return mixed[]
     */
    private function processConfiguration(array $configs): array
    {
        $configuration = new Configuration();
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }
}
