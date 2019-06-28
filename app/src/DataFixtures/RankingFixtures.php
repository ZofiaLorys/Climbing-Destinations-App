<?php
/**
 * Ranking fixtures.
 */

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class RankingFixtures.
 */
class RankingFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function loadData(ObjectManager $manager): void
    {/*

        $this->createMany(5, 'rankings', function () {
            $ranking = new Ranking();
            $ranking->setGrade($this->getRandomReference('grades'));
            $ranking->setVoter($this->getRandomReference('users'));
            $ranking->setDestination($this->getRandomReference('destinations'));


            return $ranking;

        });

        $manager->flush(); */
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [GradeFixtures::class, UserFixtures::class];
    }
}
