<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 15/12/2014
 * Time: 6:34 AM
 */

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\MovieRepository;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Cast;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Mediatype;

/**
 * @property \Doctrine\ORM\EntityManager em
 * @property MovieRepository movieRepo
 */
class MovieRepositoryTest extends KernelTestCase {

    public function setup()
    {
        self::bootKernel();
        $this->em=static::$kernel->getContainer()->get("doctrine.orm.entity_manager");
        $this->movieRepo=$this->em->getRepository("CodeSpanishMyMoviesBundle:Movie");
    }

    public function testFindCastMember(){

        /** @var Movie $movie */
        $movie = $this->movieRepo->findOneBy(array('id'=>1));

        /** @var Cast $cast */
        $castTarget=$movie->getCast()->first();
        $person=$castTarget->getPerson();
        $role=$castTarget->getRole();

        $cast = $this->movieRepo->findCastMember($person,$role,$movie);

        $this->assertNotEmpty($cast);
    }

    public function testGetMediaType(){
        $movie= $this->movieRepo->findOneBy(array('id'=>1));
        $mediaType=$this->movieRepo->findDvdCover($movie,'','s');
    }

    public function testFindDvdCover(){

        $movie = $this->em->getRepository("CodeSpanishMyMoviesBundle:Movie")
            ->findOneBy(array('id'=>1));

        $file = $this->em->getRepository("CodeSpanishMyMoviesBundle:Movie")
            ->findDvdCover($movie,"http://ecx.images-amazon.com/images/I/51RYWPdXhhL._SL75_.jpg","s");

    }


    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

}
