<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mediatype
 *
 * @ORM\Table(name="mediatype")
 * @ORM\Entity
 */
class Mediatype
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
     * @ORM\Column(name="mime", type="string", length=20, nullable=true)
     */
    private $mime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dvd", type="boolean", nullable=true)
     */
    private $dvd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="small", type="boolean", nullable=true)
     */
    private $small;

    /**
     * @var boolean
     *
     * @ORM\Column(name="medium", type="boolean", nullable=true)
     */
    private $medium;

    /**
     * @var boolean
     *
     * @ORM\Column(name="large", type="boolean", nullable=true)
     */
    private $large;

    /**
     * @var boolean
     *
     * @ORM\Column(name="featured", type="boolean", nullable=true)
     */
    private $featured;

    /**
     * @var boolean
     *
     * @ORM\Column(name="scene", type="boolean", nullable=true)
     */
    private $scene;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trailer", type="boolean", nullable=true)
     */
    private $trailer;



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
     * Set mime
     *
     * @param string $mime
     * @return Mediatype
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * Get mime
     *
     * @return string 
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set dvd
     *
     * @param boolean $dvd
     * @return Mediatype
     */
    public function setDvd($dvd)
    {
        $this->dvd = $dvd;

        return $this;
    }

    /**
     * Get dvd
     *
     * @return boolean 
     */
    public function getDvd()
    {
        return $this->dvd;
    }

    /**
     * Set small
     *
     * @param boolean $small
     * @return Mediatype
     */
    public function setSmall($small)
    {
        $this->small = $small;

        return $this;
    }

    /**
     * Get small
     *
     * @return boolean 
     */
    public function getSmall()
    {
        return $this->small;
    }

    /**
     * Set medium
     *
     * @param boolean $medium
     * @return Mediatype
     */
    public function setMedium($medium)
    {
        $this->medium = $medium;

        return $this;
    }

    /**
     * Get medium
     *
     * @return boolean 
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * Set large
     *
     * @param boolean $large
     * @return Mediatype
     */
    public function setLarge($large)
    {
        $this->large = $large;

        return $this;
    }

    /**
     * Get large
     *
     * @return boolean 
     */
    public function getLarge()
    {
        return $this->large;
    }

    /**
     * Set featured
     *
     * @param boolean $featured
     * @return Mediatype
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return boolean 
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set scene
     *
     * @param boolean $scene
     * @return Mediatype
     */
    public function setScene($scene)
    {
        $this->scene = $scene;

        return $this;
    }

    /**
     * Get scene
     *
     * @return boolean 
     */
    public function getScene()
    {
        return $this->scene;
    }

    /**
     * Set trailer
     *
     * @param boolean $trailer
     * @return Mediatype
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;

        return $this;
    }

    /**
     * Get trailer
     *
     * @return boolean 
     */
    public function getTrailer()
    {
        return $this->trailer;
    }
}
