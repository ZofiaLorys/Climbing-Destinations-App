<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\GradeRepository")
 *
 * @ORM\Table(name="grades")
 */
class Grade
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *
     * @Assert\Regex(
     *     pattern="/[1-5]/",
     *     message="You have to put number between 1-5"
     * )
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ranking", inversedBy="grade", cascade={"persist", "remove"})
     * ORM\JoinColumn(nullable=false)
     */
    private $ranking;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getValue(): ?int
    {
        return $this->value;
    }
    public function setValue(?int $value): self
    {
        $this->value = $value;
        return $this;
    }

     public function getRanking(): ?Ranking
     {
         return $this->ranking;
     }


    public function setRanking(Ranking $ranking): self
    {
        $this->ranking = $ranking;

           return $this;
      }
}

#SELECT AVG(value), rankings.destination_id, destinations.title  FROM rankings JOIN grades ON rankings.grade_id = grades.id  JOIN destinations ON destinations.id = rankings.destination_id JOIN grades ON rankings.grade_id = grades.id GROUP BY destination_id ;;