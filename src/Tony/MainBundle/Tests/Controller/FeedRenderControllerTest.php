<?php

namespace Tamago\FeedRenderBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FeedRenderControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/jobs');

        $this->assertTrue($crawler->filter('html:contains("News")')->count() > 0);

        $MaxFeed = $client->getContainer()->getParameter('tamago_feed_render.max_per_page');

        $this->assertEquals($MaxFeed,
            $crawler->filter('h3')->count()
        );
        $feedLink   = $crawler->filter('h3 a')->first();
        $feedTitle  = $feedLink->text();

        $this->assertTrue($crawler->filter('h3:contains("'. $feedTitle .'")')->count()>0);
    }
}
