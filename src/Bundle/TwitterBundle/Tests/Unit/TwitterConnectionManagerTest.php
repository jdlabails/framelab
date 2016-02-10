<?php

namespace Framelab\Bundle\TwitterBundle\Tests\Manager;

use Framelab\Bundle\TwitterBundle\Manager\TwitterConnectionManager;

/**
 * RetweeterManagerTest
 *
 * @author jd
 */
class TwitterConnectionManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testTwitterConnection()
    {
        $base = new TwitterConnectionManager("key", "secret", "accessToken", "accessTokenSecret");

        $connection = $base->getConnection();

        $this->assertEquals(get_class($connection), 'Abraham\TwitterOAuth\TwitterOAuth');
    }
}
