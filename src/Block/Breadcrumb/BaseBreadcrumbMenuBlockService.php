<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Block\Breadcrumb;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Abstract class for breadcrumb menu services.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 *
 * @deprecated since 3.x, to be removed with 4.0.
 */
abstract class BaseBreadcrumbMenuBlockService extends AbstractBreadcrumbMenuService
{
    /**
     * @var string
     */
    private $context;

    /**
     * @param string                $context
     * @param string                $name
     * @param EngineInterface       $templating
     * @param MenuProviderInterface $menuProvider
     * @param FactoryInterface      $factory
     */
    public function __construct($context, $name, EngineInterface $templating, MenuProviderInterface $menuProvider, FactoryInterface $factory)
    {
        @trigger_error(
            'The '.__CLASS__.' class is deprecated since 3.x, to be removed in 4.0. '.
            'Use '.AbstractBreadcrumbMenuService::class.' instead.',
            E_USER_DEPRECATED
        );

        parent::__construct($name, $templating, $factory);

        $this->context = $context;
    }

    /**
     * Return true if current BlockService handles the given context.
     *
     * @param string $context
     *
     * @return bool
     */
    public function handleContext($context)
    {
        return $this->context === $context;
    }

    /**
     * @return string
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return sprintf('Breadcrumb %s', $this->getContext());
    }
}
