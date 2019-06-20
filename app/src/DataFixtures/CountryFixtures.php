<?php
/**
 * Country fixture.
 */
namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CountryFixtures.
 */
class CountryFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(200, 'countries', function ($i) {

            $country = new Country();
            $country->setTitle($this->faker->unique()->country);
            return $country;
        });

        $manager->flush();
    }
}