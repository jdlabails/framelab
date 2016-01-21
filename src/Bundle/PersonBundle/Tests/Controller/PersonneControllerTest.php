<?php

namespace Framelab\PersonBundle\Tests\Controller;

use Framelab\MainBundle\Tests\Controller\MainControllerTest;

class PersonneControllerTest extends MainControllerTest
{

    public function testCompleteScenario()
    {
        // on init les label des entites qu'on va utiliser pour repererer nos
        // entites de tests sans les confondre avec d'eventuelle autres entite
        $personNameCreate = uniqid('personNameCreate');
        $personNameUpdate = uniqid('personNameUpdate');
        $serviceNameCreate = uniqid('serviceNameCreate');
        $serviceNameUpdate = uniqid('serviceNameUpdate');

        // creer un service
        $this->goAndCheckPage200('/person/service/new');
        $this->submitValidFormAndFollowRedirect(
            'Create',
            ['bundle_PersonBundle_service[nom]' => $serviceNameCreate]
        );

        // le voir dans la liste des services
        $this->goAndCheckPage200('/person/service/');
        $this->checkContent('td:contains("'.$serviceNameCreate.'")');

        // le modifier
        $serviceId = $this->crawler->filter('td:contains("'.$serviceNameCreate.'")')->siblings()->first()->text();
        $this->goAndCheckPage200('/person/service/'.$serviceId.'/edit');
        $this->submitValidFormAndFollowRedirect(
            'Update',
            ['bundle_PersonBundle_service[nom]' => $serviceNameUpdate]
        );

        // voir la modif
        $this->goAndCheckPage200('/person/service/');
        $this->checkContent('td:contains("'.$serviceNameUpdate.'")');

        $serviceId = $this->crawler->filter('td:contains("'.$serviceNameUpdate.'")')->siblings()->first()->text();

        // creer une personne
        $this->goAndCheckPage200('/person/new');
        $this->submitValidFormAndFollowRedirect(
            'Create',
            [
            'PersonBundle_personne[prenom]' => $personNameCreate,
            'PersonBundle_personne[nom]' => 'nom',
            'PersonBundle_personne[email]' => 'nom@gmail.com',
            'PersonBundle_personne[dateNaissance]' => '10/10/2014',
            'PersonBundle_personne[tel]' => '06 66 66 66 66',
            'PersonBundle_personne[service]' => $serviceId,
            'PersonBundle_personne[lieuTravail]' => 'hotel'
            ]
        );

        // la voir dans la liste
        $this->goAndCheckPage200('/person/');
        $this->checkContent('td:contains("'.$personNameCreate.'")');

        // modifier la personne
        $personId = $this->crawler->filter('td:contains("'.$personNameCreate.'")')->siblings()->first()->text();

        $this->goAndCheckPage200('/person/'.$personId.'/edit');
        $this->submitValidFormAndFollowRedirect(
            'Update',
            [
            'PersonBundle_personne[prenom]' => $personNameUpdate,
            'PersonBundle_personne[nom]' => 'nom',
            'PersonBundle_personne[email]' => 'nom@gmail.com',
            'PersonBundle_personne[dateNaissance]' => '10/10/2014',
            'PersonBundle_personne[tel]' => '06 66 66 66 66',
            'PersonBundle_personne[service]' => $serviceId,
            'PersonBundle_personne[lieuTravail]' => 'hotel'
            ]
        );

        // voir la modif
        $this->goAndCheckPage200('/person/');
        $this->checkContent('td:contains("'.$personNameUpdate.'")');

        // supprimer la personne
        $this->deleteAndCheck('/person/'.$personId.'/delete', '/'.$personNameUpdate.'/');

        // supprimer le service
        $this->deleteAndCheck('/person/service/'.$serviceId.'/delete', '/'.$serviceNameUpdate.'/');
    }

    public function testCompleteScenarioOld()
    {
        // on init les label des entites qu'on va utiliser pour repererer nos
        // entites de tests sans les confondre avec d'eventuelle autres entite
        $personNameCreate = uniqid('personNameCreate');
        $personNameUpdate = uniqid('personNameUpdate');
        $serviceNameCreate = uniqid('serviceNameCreate');
        $serviceNameUpdate = uniqid('serviceNameUpdate');

        // creer un service
        $crawler = $this->client->request('GET', '/person/service/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne/new");
        $form = $crawler->selectButton('Create')->form(array(
            'bundle_PersonBundle_service[nom]' => $serviceNameCreate
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // le voir dans la liste des services
        $crawler = $this->client->request('GET', '/person/service/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");
        $this->assertGreaterThan(0, $crawler->filter('td:contains("'.$serviceNameCreate.'")')->count(), 'Missing element td:contains("Test")');

        // le modifier
        $serviceId = $crawler->filter('td:contains("'.$serviceNameCreate.'")')->siblings()->first()->text();
        $crawler = $this->client->request('GET', '/person/service/'.$serviceId.'/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");

        $form = $crawler->selectButton('Update')->form(array(
            'bundle_PersonBundle_service[nom]' => $serviceNameUpdate
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // voir la modif
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");
        $this->assertGreaterThan(0, $crawler->filter('td:contains("'.$serviceNameUpdate.'")')->count(), 'Missing element td:contains("Test")');

        $serviceId = $crawler->filter('td:contains("'.$serviceNameUpdate.'")')->siblings()->first()->text();

        // creer une personne
        $crawler = $this->client->request('GET', '/person/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne/new");
        $form = $crawler->selectButton('PersonBundle_personne[submit]')->form(array(
            'PersonBundle_personne[prenom]' => $personNameCreate,
            'PersonBundle_personne[nom]' => 'nom',
            'PersonBundle_personne[email]' => 'nom@gmail.com',
            'PersonBundle_personne[dateNaissance]' => '10/10/2014',
            'PersonBundle_personne[tel]' => '06 66 66 66 66',
            'PersonBundle_personne[service]' => $serviceId,
            'PersonBundle_personne[lieuTravail]' => 'hotel'
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // la voir dans la liste
        $crawler = $this->client->request('GET', '/person/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");
        $this->assertGreaterThan(0, $crawler->filter('td:contains("'.$personNameCreate.'")')->count(), 'Missing element td:contains("Test")');

        // modifier la personne
        $personId = $crawler->filter('td:contains("'.$personNameCreate.'")')->siblings()->first()->text();
        $crawler = $this->client->request('GET', '/person/'.$personId.'/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");

        $form = $crawler->selectButton('Update')->form(array(
            'PersonBundle_personne[prenom]' => $personNameUpdate,
            'PersonBundle_personne[nom]' => 'nom',
            'PersonBundle_personne[email]' => 'nom@gmail.com',
            'PersonBundle_personne[dateNaissance]' => '10/10/2014',
            'PersonBundle_personne[tel]' => '06 66 66 66 66',
            'PersonBundle_personne[service]' => $serviceId,
            'PersonBundle_personne[lieuTravail]' => 'hotel'
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        // voir la modif
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");
        $this->assertGreaterThan(0, $crawler->filter('td:contains("'.$personNameUpdate.'")')->count(), 'Missing element td:contains("Test")');

        // supprimer la personne
        $crawler = $this->client->request('DELETE', '/person/'.$personId.'/delete');
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");
        $this->assertNotRegExp('/'.$personNameUpdate.'/', $this->client->getResponse()->getContent());

        // supprimer le service
        $crawler = $this->client->request('DELETE', '/person/service/'.$serviceId.'/delete');
        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/personne");
        $this->assertNotRegExp('/'.$serviceNameUpdate.'/', $this->client->getResponse()->getContent());
    }
}
