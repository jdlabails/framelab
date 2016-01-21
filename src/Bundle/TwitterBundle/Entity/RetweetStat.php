<?php

namespace Framelab\Bundle\TwitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RetweetStat
 *
 * @ORM\Table(name="retweet_stat")
 * @ORM\Entity()
 */
class RetweetStat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idTweet", type="bigint")
     */
    private $idTweet;

    /**
     * @var int
     *
     * @ORM\Column(name="idRetweet", type="bigint")
     */
    private $idRetweet;

    /**
     * @var int
     *
     * @ORM\Column(name="idRetweeter", type="integer")
     */
    private $idRetweeter;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="userScreenName", type="string", length=255)
     */
    private $userScreenName;

    /**
     * @var string, length=255
     *
     * @ORM\Column(name="userName", type="string", length=255)
     */
    private $userName;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idTweet
     *
     * @param integer $idTweet
     *
     * @return RetweetStat
     */
    public function setIdTweet($idTweet)
    {
        $this->idTweet = $idTweet;

        return $this;
    }

    /**
     * Get idTweet
     *
     * @return int
     */
    public function getIdTweet()
    {
        return $this->idTweet;
    }

    /**
     * Set idRetweet
     *
     * @param integer $idRetweet
     *
     * @return RetweetStat
     */
    public function setIdRetweet($idRetweet)
    {
        $this->idRetweet = $idRetweet;

        return $this;
    }

    /**
     * Get idRetweet
     *
     * @return int
     */
    public function getIdRetweet()
    {
        return $this->idRetweet;
    }

    /**
     * Set idRetweeter
     *
     * @param integer $idRetweeter
     *
     * @return RetweetStat
     */
    public function setIdRetweeter($idRetweeter)
    {
        $this->idRetweeter = $idRetweeter;

        return $this;
    }

    /**
     * Get idRetweeter
     *
     * @return int
     */
    public function getIdRetweeter()
    {
        return $this->idRetweeter;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return RetweetStat
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return RetweetStat
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return RetweetStat
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set user name
     *
     * @param string $userName
     *
     * @return RetweetStat
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get user screenName
     *
     * @return string
     */
    public function getUserScreenName()
    {
        return $this->userScreenName;
    }

    /**
     * Set user screenName
     *
     * @param string $userScreenName
     *
     * @return RetweetStat
     */
    public function setUserScreenName($userScreenName)
    {
        $this->userScreenName = $userScreenName;

        return $this;
    }
}
