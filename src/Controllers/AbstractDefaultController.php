<?php

namespace SON\Controllers;


use Doctrine\DBAL\Connection;
use SON\Service\DoctrineDbalInjectorInterface;
use SON\Service\TwigInjectorInterface;
use SON\Service\UrlGeneratorInjectorInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;

class AbstractDefaultController implements DoctrineDbalInjectorInterface, TwigInjectorInterface, UrlGeneratorInjectorInterface
{
    protected $db;
    protected $twig;
    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    public function setDoctrineDbalInjector(Connection $db)
    {
        $this->db = $db;
    }

    public function getDoctrineDbal()
    {
        return $this->db;
    }

    public function setTwigInjector(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getTwig()
    {
        return $this->twig;
    }

    public function setUrlGeneratorInjector(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getUrlGenerator()
    {
        return $this->urlGenerator;
    }
}