<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\SeoBundle\Tests\Request;

use PHPUnit\Framework\TestCase;
use Sonata\SeoBundle\Seo\StructuredDataAwarePage;
use Sonata\SeoBundle\Twig\Extension\StructuredDataExtension;

class StructuredDataExtensionTest extends TestCase
{
    public function testStructuredData()
    {
        $page = $this->createMock(StructuredDataAwarePage::class);
        $page->expects($this->any())->method('getStructuredData')->will($this->returnValue(file_get_contents(__DIR__.'/../../Fixtures/structured_data.jsonld')));

        $extension = new StructuredDataExtension($page, 'UTF-8');

        $this->assertEquals(
'<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "http://www.example.com",
  "name": "Unlimited Ball Bearings Corp.",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+1-401-555-1212",
    "contactType": "Customer service"
  }
}
</script>
',
            $extension->getStructuredData()
        );
    }
}
