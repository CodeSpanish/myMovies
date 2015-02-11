<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file", indexes={@ORM\Index(name="fk_file_mediatype_idx", columns={"mediatype_id"})})
 * @ORM\Entity
 */
class File
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
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="sourceUrl", type="string", length=45, nullable=true)
     */
    private $sourceurl;

    /**
     * @var string
     *
     * @ORM\Column(name="localUrl", type="string", length=45, nullable=true)
     */
    private $localurl;

    /**
     * @var \Mediatype
     *
     * @ORM\ManyToOne(targetEntity="Mediatype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mediatype_id", referencedColumnName="id")
     * })
     */
    private $mediatype;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="file")
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
     * Set title
     *
     * @param string $title
     * @return File
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set sourceurl
     *
     * @param string $sourceurl
     * @return File
     */
    public function setSourceurl($sourceurl)
    {
        $this->sourceurl = $sourceurl;

        return $this;
    }

    /**
     * Get sourceurl
     *
     * @return string 
     */
    public function getSourceurl()
    {
        return $this->sourceurl;
    }

    /**
     * Set localurl
     *
     * @param string $localurl
     * @return File
     */
    public function setLocalurl($localurl)
    {
        $this->localurl = $localurl;

        return $this;
    }

    /**
     * Get localurl
     *
     * @return string 
     */
    public function getLocalurl()
    {
        return $this->localurl;
    }

    /**
     * Set mediatype
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Mediatype $mediatype
     * @return File
     */
    public function setMediatype(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Mediatype $mediatype = null)
    {
        $this->mediatype = $mediatype;

        return $this;
    }

    /**
     * Get mediatype
     *
     * @return \CodeSpanish\Bundle\MyMoviesBundle\Entity\Mediatype 
     */
    public function getMediatype()
    {
        return $this->mediatype;
    }

    /**
     * Add movie
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie $movie
     * @return File
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
