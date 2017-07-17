<?php

namespace SON\Service;


use Symfony\Component\Routing\Generator\UrlGenerator;

interface UrlGeneratorInjectorInterface
{
    public function setUrlGeneratorInjector(UrlGenerator $urlGenerator);
    public function getUrlGenerator();
}