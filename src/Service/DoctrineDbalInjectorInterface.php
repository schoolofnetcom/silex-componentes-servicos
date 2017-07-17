<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/07/2017
 * Time: 19:22
 */

namespace SON\Service;


use Doctrine\DBAL\Connection;

interface DoctrineDbalInjectorInterface
{
    public function setDoctrineDbalInjector(Connection $db);
    public function getDoctrineDbal();
}