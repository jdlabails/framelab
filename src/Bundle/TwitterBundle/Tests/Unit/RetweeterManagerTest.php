<?php

namespace Framelab\Bundle\TwitterBundle\Tests\Manager;

use Framelab\Bundle\TwitterBundle\Manager\RetweeterManager;
use Framelab\Bundle\TwitterBundle\Entity\Retweeter;
use Framelab\Bundle\TwitterBundle\Manager\TwitterConnectionManager;

use Doctrine\Orm\EntityManager;

/**
 * Description of RetweeterManagerTest
 *
 * @author jd
 */
class RetweeterManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider shallIProvider
     */
    public function testShallI($lastLaunch, $frequencyPerDay, $res)
    {
        $retweeter = new Retweeter();
        $retweeter->setFrequencyPerDay($frequencyPerDay);
        $retweeter->setLastLaunch($lastLaunch);

        $retweeterManager = $this->getBaseInstance();

        $this->assertEquals($res, $retweeterManager->shallI($retweeter));
    }

    public function shallIProvider()
    {
        return [
            [new \DateTime('-1 day'), 3, 1],
            [new \DateTime(), 3, 0],
        ];
    }

    /**
     * @dataProvider calculateProbabilityToRetweetProvider
     */
    public function testCalculateProbabilityToRetweet($lastLaunch, $frequencyPerDay, $res)
    {
        $retweeter = new Retweeter();
        $retweeter->setFrequencyPerDay($frequencyPerDay);
        $retweeter->setLastLaunch($lastLaunch);

        $retweeterManager = $this->getBaseInstance();

        $this->assertEquals($res, round($retweeterManager->calculateProbabilityToRetweet($retweeter), 3));
    }

    public function calculateProbabilityToRetweetProvider()
    {
        return [
            'Trop longtemps : doit retweeter' => [new \DateTime('-1 day'), 4, 1],
            'Pile la période : une chance sur deux' => [new \DateTime('-4 hour'), 4, 0.5],
            'Vient de retweeter : aucune chance' => [new \DateTime(), 4, 0],

            'Retweet il y a 1h : 1 chance sur 8' => [new \DateTime('-1 hour'), 4, 1/8],
            'Retweet il y a 2h : 1 chance sur 4' => [new \DateTime('-2 hour'), 4, 1/4],
        ];
    }

    protected function getBaseInstance()
    {
        $twitterConnectionMock = $this
            ->getMockBuilder(TwitterConnectionManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $logger = $this
            ->getMockBuilder(\Monolog\Logger::class)
            ->disableOriginalConstructor()
            ->getMock();

        return new RetweeterManager($twitterConnectionMock, $entityManager, $logger);
    }
}
