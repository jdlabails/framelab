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
}
