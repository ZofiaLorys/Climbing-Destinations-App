<?php
/**
 * Destination class
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Destination
 *
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
     * See http://symfony.com/doc/current/best_practices/configuration.html#constants-vs-configuration-options.
     *
     * @constant int NUMBER_OF_ITEMS
     */
    const NUMBER_OF_ITEMS = 10;

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title
     *
     * @return Destination
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter for Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for Description.
     *
     * @param string $description
     *
     * @return Destination
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Getter for Country.
     *
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * Setter for Country.
     *
     * @param Country|null $country
     *
     * @return Destination
     */
    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Getter for Author.
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for Author.
     *
     * @param User|null $author
     *
     * @return Destination
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Adding Ranking.
     *
     * @param Ranking $ranking
     *
     * @return Destination
     */
    public function addRanking(Ranking $ranking): self
    {
        if (!$this->rankings->contains($ranking)) {
            $this->rankings[] = $ranking;
            $ranking->setDestination($this);
        }

        return $this;
    }

    /**
     * Removing ranking.
     *
     * @param Ranking $ranking
     *
     * @return Destination
     */
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

    /**
     * Getter for ranking.
     *
     * @return ArrayCollection
     */
    public function getRankings()
    {
        return $this->rankings;
    }

    /**
     * If destination already ranked by user,
     * then 1 elem collection is return (given user ranking data)
     * Empty collection returned when user did not vote.
     *
     * @param User $user
     *
     * @return ArrayCollection
     */
    public function getRankedByUser(User $user)
    {
        return $this->getRankings()->filter(function (Ranking $ranking) use ($user) {
            return $ranking->getVoter()->getId() == $user->getId();
        });
    }
}
