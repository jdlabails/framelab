<?php

namespace Framelab\Bundle\TwitterBundle\Manager;

use \Framelab\Bundle\TwitterBundle\Entity;
use Abraham\TwitterOAuth\TwitterOAuth;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

/**
 * Description of Retweeter
 *
 * @author jd
 */
class RetweeterManager
{
    /**
     *
     * @var TwitterOAuth
     */
    private $twitterConnection;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var Logger
     */
    private $logger;

    /**
     *
     * @var string
     */
    private $explaination;

    /**
     *
     * @param TwitterConnectionManager $twitterConnection
     * @param EntityManager            $entityManager
     * @param Logger                   $logger
     */
    public function __construct(
        TwitterConnectionManager $twitterConnection,
        EntityManager $entityManager,
        Logger $logger
    ) {
        $this->twitterConnection = $twitterConnection;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function getExplaination()
    {
        return $this->explaination;
    }
    /**
     *
     * @param \Framelab\Bundle\TwitterBundle\Entity\Retweeter $retweeter
     * @return boolean
     */
    public function launch(Entity\Retweeter $retweeter)
    {
        if (is_null($retweeter) || !$retweeter->getActif()) {
            $this->explaination = $retweeter->getName().' is a bad retweeter or inactive one';
            $this->logger->critical($this->explaination);

            return false;
        }

        if (!$this->shallI($retweeter)) {
            $this->explaination = $retweeter->getName().' decides to not retweet';
            $this->logger->notice($this->explaination);

            return false;
        }

        $param = [
            'q' => urlencode($retweeter->getQuery()),
            'f' => 'tweets',
            'src' => 'typd',
            'count' => 3,
            'lang' => 'fr',
            'result_type' => 'popular'
        ];
        $statuses = $this->twitterConnection->getConnection()->get("search/tweets", $param)->statuses;
        if (empty($statuses)) {
            $this->explaination = ' No recent tweet found for query of '.$retweeter->getName();
            $this->logger->notice($this->explaination);

            return false;
        }

        foreach ($statuses as $tweet) {
            try {
                $retweet = $this->retweet($tweet);
            } catch (\Exception $ex) {
                $this->explaination = $retweeter->getName().' tries to re-retweet... oh lala';
                $this->logger->warning($this->explaination);
                continue;
            }
            $this->statThis($retweeter, $retweet);

            return true;
        }
    }

    /**
     * Decide if it's time for retweet or not
     *
     * @param Retweeter $retweeter
     *
     * @return boolean
     */
    public function shallI(Entity\Retweeter $retweeter)
    {
        return rand(0, 100)/100 < $this->calculateProbabilityToRetweet($retweeter);
    }

    /**
     * Retweet the passed tweet
     *
     * @param object $tweet
     * @return object
     * @throws \Exception
     */
    public function retweet($tweet)
    {
        $retweet = $this
                ->twitterConnection
                ->getConnection()
                ->post("statuses/retweet", ['id' => $tweet->id]);

        if (isset($retweet->errors)) {
            throw new \Exception('Deja retweeté');
        }

        return $retweet;
    }

    /**
     * Notifie le retweet
     *
     * @param \Framelab\Bundle\TwitterBundle\Entity\Retweeter $retweeter
     * @param object                                            $retweet
     */
    public function statThis(Entity\Retweeter $retweeter, $retweet)
    {
        $retweetStat = new Entity\RetweetStat();
        $retweetStat
            ->setDatetime(new \DateTime())
            ->setIdRetweeter($retweeter->getId())
            ->setIdRetweet($retweet->id)
            ->setIdTweet($retweet->retweeted_status->id)
            ->setIdUser($retweet->retweeted_status->user->id)
            ->setText($retweet->retweeted_status->text)
            ->setUserName($retweet->retweeted_status->user->name)
            ->setUserScreenName($retweet->retweeted_status->user->screen_name);

        $retweeter->setLastLaunch(new \Datetime());

        $this->entityManager->persist($retweetStat);
        $this->entityManager->persist($retweeter);
        $this->entityManager->flush();

        $this->logger->notice('Retweeter "'.$retweeter->getName().'" has retweet the '.$retweet->id.'retweet');
    }

    /**
     * Calcule la proba de retweeter
     *
     * @param \Framelab\Bundle\TwitterBundle\Entity\Retweeter $retweeter
     *
     * @return float € [0, 1]
     */
    public function calculateProbabilityToRetweet(Entity\Retweeter $retweeter)
    {
        // retwteet plage : de 7h à 23h, soit 16h
        $period = 16*60/$retweeter->getFrequencyPerDay();

        // temps passé depuis le dernier tweet
        $spentTime = date_diff(new \DateTime, $retweeter->getLastLaunch());
        $spentTime = $spentTime->format('%d')* 60*24 + $spentTime->format('%h')*60 + $spentTime->format('%i');

        // on veut une proba de 0.5 si cela fait 5h qu'on a pas tweeter et que la periode est aussi de 5h
        $proba = 0.5 * $spentTime / $period;

        if ($proba > 1) {
            return 1;
        }

        if ($proba < 0) {
            return 0;
        }

        return $proba;
    }
}
