<?php

/**
 * Country entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;



/**
 * Class Country.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ORM\Table(name="countries")
 *
 * @UniqueEntity(fields={"title"})
 */
class Country
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     unique=true
     * )
     *
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private $title;



    /**
     * Destinations.
     *
     * @var Collection|null
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Destination",
     *     mappedBy="destination",
     *      fetch="EXTRA_LAZY"
     * )
     */
    private $destinations;




    public function __construct()
    {
        $this->destinations = new ArrayCollection();
    }


    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 10;


    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }


    /**
     * Setter for Title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Collection|Destination[]
     */
    public function getDestinations(): Collection
    {
        return $this->destinations;
    }

    public function addDestination(Destination $destination): self
    {
        if (!$this->destinations->contains($destination)) {
            $this->destinations[] = $destination;
            $destination->setCountry($this);
        }

        return $this;
    }

    public function removeDestination(Destination $destination): self
    {
        if ($this->destinations->contains($destination)) {
            $this->destinations->removeElement($destination);
            // set the owning side to null (unless already changed)
            if ($destination->getCountry() === $this) {
                $destination->setCountry(null);
            }
        }

        return $this;
    }
}
