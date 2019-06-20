<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\RankingRepository")
 *
 * @ORM\Table(name="rankings")
 *
 * @UniqueEntity(
 *     fields={"destination", "voter"},
 *     message="Już zagłosowałeś na tą miejscowkę",
 *     ignoreNull=false
 * )
 *
 */
class Ranking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rankings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voter;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Destination", inversedBy="rankings")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Grade")
     */
    private $grade;

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
    public function getGrade(): ?Grade
    {
        return $this->grade;
    }
    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;
        return $this;
    }
    public function getVoter(): ?User
    {
        return $this->voter;
    }
    public function setVoter(?User $voter): self
    {
        $this->voter = $voter;
        return $this;
    }
    public function getDestination(): ?Destination
    {
        return $this->destination;
    }
    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;
        return $this;
    }
}