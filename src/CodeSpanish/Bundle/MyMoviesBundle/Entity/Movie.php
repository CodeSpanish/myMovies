<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="CodeSpanish\Bundle\MyMoviesBundle\Entity\MovieRepository")
 */
class Movie
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
     * @ORM\Column(name="english_title", type="string", length=45, nullable=false)
     */
    private $englishTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="original_title", type="string", length=45, nullable=false)
     */
    private $originalTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="storyline", type="text", nullable=true)
     */
    private $storyline;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", nullable=true)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="runtime", type="integer", nullable=true)
     */
    private $runtime;

    /**
     * @var string
     *
     * @ORM\Column(name="amazon_id", type="string", length=45, nullable=true)
     */
    private $amazonId;

    /**
     * @var string
     *
     * @ORM\Column(name="imdb_id", type="string", length=45, nullable=true)
     */
    private $imdbId;

    /**
     * @var string
     *
     * @ORM\Column(name="wikipedia_id", type="string", length=45, nullable=true)
     */
    private $wikipediaId;

    /**
     * @var string
     *
     * @ORM\Column(name="rottentomatoes_id", type="string", length=45, nullable=true)
     */
    private $rottentomatoesId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published", type="datetime", nullable=true)
     */
    private $published;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Cast", inversedBy="movie")
     * @ORM\JoinTable(name="movie_casts",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="cast_id", referencedColumnName="id")
     *   }
     * )
     */
    private $cast;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Country", inversedBy="movie")
     * @ORM\JoinTable(name="movie_countries",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     *   }
     * )
     */
    private $country;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="File", inversedBy="movie")
     * @ORM\JoinTable(name="movie_files",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     *   }
     * )
     */
    private $file;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Review", inversedBy="movie")
     * @ORM\JoinTable(name="movie_reviews",
     *   joinColumns={
     *     @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="review_id", referencedColumnName="id"),
     *     @ORM\JoinColumn(name="review_source_id", referencedColumnName="source_id")
     *   }
     * )
     */
    private $review;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cast = new \Doctrine\Common\Collections\ArrayCollection();
        $this->country = new \Doctrine\Common\Collections\ArrayCollection();
        $this->file = new \Doctrine\Common\Collections\ArrayCollection();
        $this->review = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set englishTitle
     *
     * @param string $englishTitle
     * @return Movie
     */
    public function setEnglishTitle($englishTitle)
    {
        $this->englishTitle = $englishTitle;

        return $this;
    }

    /**
     * Get englishTitle
     *
     * @return string 
     */
    public function getEnglishTitle()
    {
        return $this->englishTitle;
    }

    /**
     * Set originalTitle
     *
     * @param string $originalTitle
     * @return Movie
     */
    public function setOriginalTitle($originalTitle)
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * Get originalTitle
     *
     * @return string 
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * Set storyline
     *
     * @param string $storyline
     * @return Movie
     */
    public function setStoryline($storyline)
    {
        $this->storyline = $storyline;

        return $this;
    }

    /**
     * Get storyline
     *
     * @return string 
     */
    public function getStoryline()
    {
        return $this->storyline;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set runtime
     *
     * @param integer $runtime
     * @return Movie
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return integer 
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set amazonId
     *
     * @param string $amazonId
     * @return Movie
     */
    public function setAmazonId($amazonId)
    {
        $this->amazonId = $amazonId;

        return $this;
    }

    /**
     * Get amazonId
     *
     * @return string 
     */
    public function getAmazonId()
    {
        return $this->amazonId;
    }

    /**
     * Set imdbId
     *
     * @param string $imdbId
     * @return Movie
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return string 
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set wikipediaId
     *
     * @param string $wikipediaId
     * @return Movie
     */
    public function setWikipediaId($wikipediaId)
    {
        $this->wikipediaId = $wikipediaId;

        return $this;
    }

    /**
     * Get wikipediaId
     *
     * @return string 
     */
    public function getWikipediaId()
    {
        return $this->wikipediaId;
    }

    /**
     * Set rottentomatoesId
     *
     * @param string $rottentomatoesId
     * @return Movie
     */
    public function setRottentomatoesId($rottentomatoesId)
    {
        $this->rottentomatoesId = $rottentomatoesId;

        return $this;
    }

    /**
     * Get rottentomatoesId
     *
     * @return string 
     */
    public function getRottentomatoesId()
    {
        return $this->rottentomatoesId;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     * @return Movie
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Add cast
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Cast $cast
     * @return Movie
     */
    public function addCast(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Cast $cast)
    {
        $this->cast[] = $cast;

        return $this;
    }

    /**
     * Remove cast
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Cast $cast
     */
    public function removeCast(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Cast $cast)
    {
        $this->cast->removeElement($cast);
    }

    /**
     * Get cast
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * Add country
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Country $country
     * @return Movie
     */
    public function addCountry(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Country $country)
    {
        $this->country[] = $country;

        return $this;
    }

    /**
     * Remove country
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Country $country
     */
    public function removeCountry(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Country $country)
    {
        $this->country->removeElement($country);
    }

    /**
     * Get country
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add file
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\File $file
     * @return Movie
     */
    public function addFile(\CodeSpanish\Bundle\MyMoviesBundle\Entity\File $file)
    {
        $this->file[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\File $file
     */
    public function removeFile(\CodeSpanish\Bundle\MyMoviesBundle\Entity\File $file)
    {
        $this->file->removeElement($file);
    }

    /**
     * Get file
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add review
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Review $review
     * @return Movie
     */
    public function addReview(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Review $review)
    {
        $this->review[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \CodeSpanish\Bundle\MyMoviesBundle\Entity\Review $review
     */
    public function removeReview(\CodeSpanish\Bundle\MyMoviesBundle\Entity\Review $review)
    {
        $this->review->removeElement($review);
    }

    /**
     * Get review
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReview()
    {
        return $this->review;
    }
}
