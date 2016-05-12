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

use Exporter\Handler;
use Exporter\Writer\SitemapWriter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Create a sitemap.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SitemapGeneratorCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('sonata:seo:sitemap');

        $this->addArgument('folder', InputArgument::REQUIRED, 'The folder to store the sitemap.xml file');
        $this->addArgument('host', InputArgument::REQUIRED, 'Set the host');
        $this->addOption('scheme', null, InputOption::VALUE_OPTIONAL, 'Set the scheme', 'http');
        $this->addOption('baseurl', null, InputOption::VALUE_OPTIONAL, 'Set the base url', '');
        $this->addOption('sitemap_path', null, InputOption::VALUE_OPTIONAL, 'Set the sitemap relative path (if in a specific folder)', '');

        $this->setDescription('Create a sitemap');
        $this->setHelp(<<<'EOT'
The <info>sonata:seo:sitemap</info> command create new sitemap files (index + sitemap).

EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('router')->getContext()->setHost($input->getArgument('host'));
        $this->getContainer()->get('router')->getContext()->setScheme($input->getOption('scheme'));
        $this->getContainer()->get('router')->getContext()->setBaseUrl($input->getOption('baseurl'));

        $tempFolder = sys_get_temp_dir().'/sonata_sitemap_'.md5(__DIR__);

        $fs = new Filesystem();

        // step 1
        $output->writeln(sprintf('Creating temporary folder: %s', $tempFolder));

        if ($fs->exists($tempFolder)) {
            $output->writeln('<error>The temporary folder already exists</error>');
            $output->writeln('<error>If the task is not running please delete this folder</error>');

            return 1;
        }

        $fs->mkdir($tempFolder);

        // step 2
        $manager = $this->getContainer()->get('sonata.seo.sitemap.manager');

        // step 3
        $output->writeln(sprintf('Generating sitemap - this can take a while'));
        foreach ($manager as $group => $sitemap) {
            $write = new SitemapWriter($tempFolder, $group, $sitemap->types, false);

            try {
                Handler::create($sitemap->sources, $write)->export();
            } catch (\Exception $e) {
                $fs->remove($tempFolder);

                throw $e;
            }
        }

        // generate global sitemap index
        $appendPath = $input->hasOption('sitemap_path') ? $input->getOption('sitemap_path') : $input->getOption('baseurl');
        SitemapWriter::generateSitemapIndex($tempFolder, sprintf('%s://%s%s', $input->getOption('scheme'), $input->getArgument('host'), $appendPath), 'sitemap*.xml', 'sitemap.xml');

        // step 4
        $output->writeln(sprintf('Moving temporary file to %s ...', $input->getArgument('folder')));

        $oldFiles = Finder::create()->files()->name('sitemap*.xml')->in($input->getArgument('folder'));
        foreach ($oldFiles as $file) {
            $fs->remove($file->getRealPath());
        }

        $newFiles = Finder::create()->files()->name('sitemap*.xml')->in($tempFolder);
        foreach ($newFiles as $file) {
            $fs->rename($file->getRealPath(), sprintf('%s/%s', $input->getArgument('folder'), $file->getFilename()));
        }

        $fs->remove($tempFolder);

        $output->writeln('<info>done!</info>');
    }
}
