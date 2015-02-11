<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cast
 *
 * @ORM\Table(name="cast", indexes={@ORM\Index(name="fk_cast_person1_idx", columns={"person_id"}), @ORM\Index(name="fk_cast_role1_idx", columns={"role_id"})})
 * @ORM\Entity
 */
class Cast
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
     * @var \Person
     *
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * })
     */
    private $person;

    /**
     * @var \Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="cast")
     */
    private $movie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movie = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set person
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Person $person
     * @return Cast
     */
    public function setPerson(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \CodeSpanish\Bundle\MyMoviesBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set role
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Role $role
     * @return Cast
     */
    public function setRole(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \CodeSpanish\Bundle\MyMoviesBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add movie
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie $movie
     * @return Cast
     */
    public function addMovie(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie $movie)
    {
        $this->movie[] = $movie;

        return $this;
    }

    /**
     * Remove movie
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie $movie
     */
    public function removeMovie(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie $movie)
    {
        $this->movie->removeElement($movie);
    }

    /**
     * Get movie
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovie()
    {
        return $this->movie;
    }
}
