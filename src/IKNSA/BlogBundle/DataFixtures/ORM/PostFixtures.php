<?php
// src/BlogBundle/DataFixtures/ORM/PostFixtures.php

namespace IKNSA\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IKNSA\BlogBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $coucou = new Post();
        $coucou->setTitle('coucou');
        $coucou->setSummary('test');
        $coucou->setContent('test');
        $coucou->setCreatedAt(new \Datetime('NOW'));

        $manager->persist($coucou);
        $manager->flush();

        $coucou2 = new Post();
        $coucou2->setTitle('maison');
        $coucou2->setSummary('maison');
        $coucou2->setContent('maison');
        $coucou2->setCreatedAt(new \Datetime('NOW'));

        $manager->persist($coucou2);
        $manager->flush();

        $coucou3 = new Post();
        $coucou3->setTitle('rocher');
        $coucou3->setSummary('rocher');
        $coucou3->setContent('rocher');
        $coucou3->setCreatedAt(new \Datetime('NOW'));

        $manager->persist($coucou3);
        $manager->flush();
    }
}