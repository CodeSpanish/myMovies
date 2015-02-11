<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="Imdb", columns={"imdbId"}), @ORM\Index(name="Rottentomatoes", columns={"rottentomatoesId"})})
 * @ORM\Entity
 */
class Person
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=45, nullable=false)
     */
    private $fullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    private $bio;

    /**
     * @var string
     *
     * @ORM\Column(name="imdbId", type="string", length=45, nullable=true)
     */
    private $imdbid;

    /**
     * @var string
     *
     * @ORM\Column(name="rottentomatoesId", type="string", length=45, nullable=true)
     */
    private $rottentomatoesid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Award", inversedBy="person")
     * @ORM\JoinTable(name="person_awards",
     *   joinColumns={
     *     @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="award_id", referencedColumnName="id")
     *   }
     * )
     */
    private $award;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->award = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return Person
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return Person
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set bio
     *
     * @param string $bio
     * @return Person
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string 
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set imdbid
     *
     * @param string $imdbid
     * @return Person
     */
    public function setImdbid($imdbid)
    {
        $this->imdbid = $imdbid;

        return $this;
    }

    /**
     * Get imdbid
     *
     * @return string 
     */
    public function getImdbid()
    {
        return $this->imdbid;
    }

    /**
     * Set rottentomatoesid
     *
     * @param string $rottentomatoesid
     * @return Person
     */
    public function setRottentomatoesid($rottentomatoesid)
    {
        $this->rottentomatoesid = $rottentomatoesid;

        return $this;
    }

    /**
     * Get rottentomatoesid
     *
     * @return string 
     */
    public function getRottentomatoesid()
    {
        return $this->rottentomatoesid;
    }

    /**
     * Add award
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Award $award
     * @return Person
     */
    public function addAward(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Award $award)
    {
        $this->award[] = $award;

        return $this;
    }

    /**
     * Remove award
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Award $award
     */
    public function removeAward(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Award $award)
    {
        $this->award->removeElement($award);
    }

    /**
     * Get award
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAward()
    {
        return $this->award;
    }
}
