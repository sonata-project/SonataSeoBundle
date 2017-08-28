<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create robots.txt.
 */
final class RobotsTxtGeneratorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('sonata:seo:robotstxt');

        $this->addArgument('folder', InputArgument::OPTIONAL, 'The directory where to write the robots.txt file');

        $this->setDescription('Create robots.txt');
        $this->setHelp(<<<'EOT'
The <info>sonata:seo:robotstxt</info> command creates new robots.txt file.

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = $this->getContainer()->get('sonata.seo.robotstxt.generator');
        $robotsConfig = $this->getContainer()->getParameter('sonata_seo.robotstxt');
        if (empty($robotsConfig)) {
            throw new \RuntimeException('No sonata_seo_robotstxt config found, check your config.yml');
        }

        $folder = $this->getContainer()->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web';
        if ($input->hasOption('folder')) {
            $folder = $input->getOption('folder');
        }

        $output->writeln(sprintf('Generating robots.txt in %s', $input->getArgument('folder')));
        $generator->generate($robotsConfig, $folder);

        $output->writeln('<info>done!</info>');
    }
}
