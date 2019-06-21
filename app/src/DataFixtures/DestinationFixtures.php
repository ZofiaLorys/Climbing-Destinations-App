<?php
/**
 * Destination fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Destination;


use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DestinationFixtures.
 */
class DestinationFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     * @return destination
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(50, 'destinations', function () {
            $destination = new Destination();
            $destination->setTitle($this->faker->word);
            $destination->setDescription($this->faker->paragraph);
            $destination->setCountry($this->getRandomReference('countries'));
            $destination->setAuthor($this->getRandomReference('users'));

            return $destination;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CountryFixtures::class, UserFixtures::class];
    }
}