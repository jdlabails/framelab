<?php

namespace Framelab\Bundle\TwitterBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RetweeterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('framelab:retweet')->setDescription('Launch retweeters');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $retweeters = $em->getRepository('TwitterBundle:Retweeter')->findAll();
        foreach ($retweeters as $retweeter) {
            $this->getContainer()->get('twitter.retweeter')->launch($retweeter);
        }

        return 1;
    }
}
