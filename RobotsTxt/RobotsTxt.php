<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\RobotsTxt;


final class RobotsTxt
{
    /**
     * The lines of for the robots.txt.
     *
     * @var string[]
     */
    protected $lines = array();

    /**
     * Generate the robots.txt data.
     *
     * @return string
     */
    public function generate()
    {
        return implode(PHP_EOL, $this->lines);
    }

    /**
     * Add a Sitemap to the robots.txt.
     *
     * @param string $sitemap
     */
    public function addSitemap($sitemap)
    {
        $this->addLine("Sitemap: $sitemap");
    }

    /**
     * Add a User-agent to the robots.txt.
     *
     * @param string $userAgent
     */
    public function addUserAgent($userAgent)
    {
        $this->addLine("User-agent: $userAgent");
    }

    /**
     * Add a Host to the robots.txt.
     *
     * @param string $host
     */
    public function addHost($host)
    {
        $this->addLine("Host: $host");
    }

    /**
     * Add a Crawl-delay to the robots.txt.
     *
     * @param int $delay
     */
    public function addCrawlDelay($delay)
    {
        $this->addLine("Crawl-delay: $delay");
    }

    /**
     * Add a disallow rule to the robots.txt.
     *
     * @param string|array $directories
     */
    public function addDisallow($directories)
    {
        $this->addRuleLine($directories, 'Disallow');
    }

    /**
     * Add a allow rule to the robots.txt.
     *
     * @param string|array $directories
     */
    public function addAllow($directories)
    {
        $this->addRuleLine($directories, 'Allow');
    }

    /**
     * Add a comment to the robots.txt.
     *
     * @param string $comment
     */
    public function addComment($comment)
    {
        $this->addLine("# $comment");
    }

    /**
     * Add a spacer to the robots.txt.
     */
    public function addSpacer()
    {
        $this->addLine('');
    }

    /**
     * Add a line to the robots.txt.
     *
     * @param string $line
     */
    protected function addLine($line)
    {
        $this->lines[] = (string) $line;
    }

    /**
     * Add multiple lines to the robots.txt.
     *
     * @param string|array $lines
     */
    protected function addLines($lines)
    {
        foreach ((array) $lines as $line) {
            $this->addLine($line);
        }
    }

    /**
     * Reset the lines.
     */
    public function reset()
    {
        $this->lines = array();
    }

    /**
     * Add a rule to the robots.txt.
     *
     * @param string|array $directories
     * @param string       $rule
     */
    private function addRuleLine($directories, $rule)
    {
        foreach ((array) $directories as $directory) {
            $this->addLine("$rule: $directory");
        }
    }
}
