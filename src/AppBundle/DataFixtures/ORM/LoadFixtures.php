<?php
/**
 * Created by PhpStorm.
 * User: Sofyann
 * Date: 15/01/2018
 * Time: 07:55
 */


namespace AppBundle\DataFixtures\ORM;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        Fixtures::load(__DIR__ . '/fixtures.yml', $manager);
    }
}