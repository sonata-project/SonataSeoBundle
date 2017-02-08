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
use Symfony\Component\Filesystem\Filesystem;

/**
 * Create robots.txt
 */
class RobotsTxtGeneratorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('sonata:seo:robotstxt');

        $this->addArgument('folder', InputArgument::REQUIRED, 'The folder to store the robots.txt file');

        $this->setDescription('Create robots.txt');
        $this->setHelp(<<<'EOT'
The <info>sonata:seo:robotstxt</info> command create new robots.txt file.

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        // step 1
        $generator = $this->getContainer()->get('sonata.seo.robotstxt.generator');
        $robotsConfig = $this->getContainer()->getParameter('sonata_seo.robotstxt');
        if(empty($robotsConfig)){
            throw new \RuntimeException("No sonata_seo_robotstxt config found, check your config.yml");
        }

        // step 2
        $output->writeln(sprintf('Generating robots.txt in %s', $input->getArgument('folder')));
        $robotsTxt = $generator->buildRobotsTxt($robotsConfig);

        $filePath = $input->getArgument('folder').DIRECTORY_SEPARATOR."robots.txt";

        if(!$fs->exists($filePath)){
            $fs->touch($filePath);
        }

        // step 3
        $content = $robotsTxt->generate();

        // step 4
        $fs->dumpFile($filePath, $content);

        $output->writeln('<info>done!</info>');
    }
}
