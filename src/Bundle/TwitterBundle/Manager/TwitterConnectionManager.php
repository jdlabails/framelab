<?php

namespace Framelab\Bundle\TwitterBundle\Manager;

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Description of Connection
 *
 * @author jd
 */
class TwitterConnectionManager
{
    private $connection;

    public function __construct($key, $secret, $accessToken, $accessTokenSecret)
    {
        $this->connection = new TwitterOAuth($key, $secret, $accessToken, $accessTokenSecret);
    }

    public function getConnection()
    {
        return $this->connection;
    }

}
