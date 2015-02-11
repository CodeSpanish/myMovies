<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Award
 *
 * @ORM\Table(name="award", indexes={@ORM\Index(name="fk_award_festival1_idx", columns={"festival_id"})})
 * @ORM\Entity
 */
class Award
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
     * @var \Festival
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Festival")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="festival_id", referencedColumnName="id")
     * })
     */
    private $festival;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", mappedBy="award")
     */
    private $person;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->person = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set id
     *
     * @param integer $id
     * @return Award
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Award
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set festival
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Festival $festival
     * @return Award
     */
    public function setFestival(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Festival $festival)
    {
        $this->festival = $festival;

        return $this;
    }

    /**
     * Get festival
     *
     * @return \CodeSpanish\Bundle\MyMoviesBundle\Entity\Festival 
     */
    public function getFestival()
    {
        return $this->festival;
    }

    /**
     * Add person
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Person $person
     * @return Award
     */
    public function addPerson(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Person $person)
    {
        $this->person[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Person $person
     */
    public function removePerson(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Person $person)
    {
        $this->person->removeElement($person);
    }

    /**
     * Get person
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPerson()
    {
        return $this->person;
    }
}
