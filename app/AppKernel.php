<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{

    public function registerBundles()
    {
        $bundles = [
            // la base
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // gestion des users
            new FR3D\LdapBundle\FR3DLdapBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            //pour twitter
            //new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new M6Web\Bundle\GuzzleHttpBundle\M6WebGuzzleHttpBundle(),
            // pour les fixtures
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            // our bundles
            new Framelab\Bundle\PersonBundle\PersonBundle(),
            new Framelab\Bundle\TwitterBundle\TwitterBundle(),
            new Framelab\Bundle\MainBundle\MainBundle(),
            new Framelab\Bundle\UserBundle\UserBundle(),
            new Framelab\Bundle\PostBundle\PostBundle(),
            new Framelab\Bundle\DocumentBundle\DocumentBundle(),
            new Framelab\Bundle\RateBundle\RateBundle(),
            new JD\PhpProjectAnalyzerBundle\JDPhpProjectAnalyzerBundle(),
        ];

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
