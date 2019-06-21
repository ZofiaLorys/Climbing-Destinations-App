<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DestinationRepository")
 *
 * @ORM\Table(name="destinations")
 */
class Destination
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     *
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="15",
     * )
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *	@Assert\Length(
     *     min="3",
     *     max="500",
     * )
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="destinations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="destinations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ranking", mappedBy="destination", orphanRemoval=true)
     */
    private $rankings;


    public function __construct()
    {
        $this->rankings = new ArrayCollection();
    }

    /**
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 10;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function addRanking(Ranking $ranking): self
    {
        if (!$this->rankings->contains($ranking)) {
            $this->rankings[] = $ranking;
            $ranking->setDestination($this);
        }
        return $this;
    }
    public function removeRanking(Ranking $ranking): self
    {
        if ($this->rankings->contains($ranking)) {
            $this->rankings->removeElement($ranking);
            // set the owning side to null (unless already changed)
            if ($ranking->getDestination() === $this) {
                $ranking->setDestination(null);
            }
        }
        return $this;
    }


}
