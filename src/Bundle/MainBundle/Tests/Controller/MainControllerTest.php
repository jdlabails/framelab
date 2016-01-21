<?php

namespace Framelab\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class MainControllerTest extends WebTestCase
{

    protected $client;

    protected $crawler;

    public function setUp()
    {
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'jd',
            '_password' => 'jd',
        ));
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    protected function goAndCheckPage200($url)
    {
        $this->crawler = $this->client->request('GET', $url);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET $url");
    }

    protected function submitValidFormAndFollowRedirect($btnLabel, $formParam)
    {
        $form = $this->crawler->selectButton($btnLabel)->form($formParam);
        $this->client->submit($form);
        $this->crawler = $this->client->followRedirect();
    }

    protected function checkContent($content)
    {
        $this->assertGreaterThan(0, $this->crawler->filter($content)->count(), 'Missing element '.$content);
    }

    protected function deleteAndCheck($url, $RegexToCheck)
    {
        $crawler = $this->client->request('DELETE', $url);
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /annuaire/personne");
        $this->assertNotRegExp($RegexToCheck, $this->client->getResponse()->getContent());
    }
}
