<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Grade;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class GradeFixtures.
 */
class GradeFixtures extends Fixture
{
    /**
     * Object manager.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        for ($i = 1; $i < 6; ++$i) {
            $grade = new Grade();
            $grade->setValue($i);
            $this->manager->persist($grade);
        }

        $manager->flush();
    }
}
