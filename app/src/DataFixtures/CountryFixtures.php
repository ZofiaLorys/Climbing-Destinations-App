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
        $this->createMany(10, 'countries', function ($i) {
            $country = new Country();
            $country->setTitle($this->faker->country);


            return $country;
        });

        $manager->flush();
    }
}