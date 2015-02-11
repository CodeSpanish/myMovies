<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MovieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MovieRepository extends EntityRepository
{
    /**
     * Gets a cast object for the given movie and actor/director
     * @param Person $person
     * @param Movie $movie
     * @return array
     */
    public function findCastMember($person, $role, $movie){

        $cast=$this->_em->getRepository('CodeSpanishMyMoviesBundle:Cast')
            ->findOneBy(array(
                'person'=>$person,
                'role'=>$role
            ));
/*
        $query = $this->_em->createQueryBuilder()
            ->select('cast')
            ->from('CodeSpanishMyMoviesBundle:Cast','cast')
            ->innerJoin('cast.movie','movie')
            ->where('cast.person=:person')
            ->andWhere('cast.role=:role')
            ->andWhere('movie.id=:movieId')
            ->setParameter('person',$person)
            ->setParameter('role',$role)
            ->setParameter('movieId',$movie->getId())
            ->getQuery();

        $cast=$query->getResult();
*/
        if(empty($cast)){
            $cast=new Cast();
            $cast->setPerson($person);
            $cast->setRole($role);
            $cast->addMovie($movie);
            $this->_em->persist($cast);
            $this->_em->flush($cast);
            $movie->addCast($cast);
        }
        else{
            if(!$movie->getCast()->contains($cast)){
                $movie->addCast($cast);
            }
        }

        return $cast;
    }

    public function findCountry($name){
        $country=$this->_em->getRepository("CodeSpanishMyMoviesBundle:Country")
            ->findOneBy(array(
                'shortName'=>$name
            ));

        if(empty($country)){
            $country=new Country();
            $country->setShortName($name);
            $this->_em->persist($country);
            $this->_em->flush($country);
        }

        return $country;
    }

    /**
     * Retrieves the mediaType for a DVD cover of a given size
     * @param Movie $movie
     * @param string $url
     * @param string $size
     * @return Mediatype
     */
    public function findDvdCover($movie, $url, $size){

        $small=$medium=$large=false;

        if($size='s')$small=true;
        if($size='m')$medium=true;
        if($size='l')$large=true;

        //We check that the cover doesn't exist in the db
        $query=$this->_em->createQueryBuilder()
            ->select('file')
            ->from('CodeSpanishMyMoviesBundle:File','file')
            ->innerJoin('file.movie','movie')
            ->where('file.sourceurl=:url')
            ->andWhere('movie.id=:movieId')
            ->setParameter('url',$url)
            ->setParameter('movieId',$movie->getId())
            ->getQuery();
        $file=$query->getResult();

        if(empty($file)){

            //We then check if the mediatype already exists
            $mediaType = $this->_em->getRepository("CodeSpanishMyMoviesBundle:Mediatype")
                ->findOneBy(array(
                    'mime'=>'image/jpeg',
                    'dvd'=>true,
                    'featured'=>false,
                    'small'=>$small,
                    'medium'=>$medium,
                    'large'=>$large,
                    'scene'=>false,
                    'trailer'=>false
                ));

            if(empty($mediaType)){
                $mediaType = new Mediatype();
                $mediaType->setMime('image/jpeg');
                $mediaType->setDvd(true);
                $mediaType->setFeatured(false);
                $mediaType->setSmall($small);
                $mediaType->setMedium($medium);
                $mediaType->setLarge($large);
                $mediaType->setScene(false);
                $mediaType->setTrailer(false);
                $this->_em->persist($mediaType);
                $this->_em->flush($mediaType);
            }

            $file=new File();
            $file->setMediatype($mediaType);
            $file->addMovie($movie);
            $file->setSourceurl($url);
            $this->_em->persist($file);
            $this->_em->flush($file);
        }

        return $file;
    }

    /**
     * @param $movie
     * @param $url
     * @return array|File
     */
    public function findTrailer($movie, $url){

        //We check that the cover doesn't exist in the db
        $query=$this->_em->createQueryBuilder()
            ->select('file')
            ->from('CodeSpanishMyMoviesBundle:File','file')
            ->innerJoin('file.movie','movie')
            ->where('file.sourceurl=:url')
            ->andWhere('movie.id=:movieId')
            ->setParameter('url',$url)
            ->setParameter('movieId',$movie->getId())
            ->getQuery();
        $file=$query->getResult();

        if(empty($file)){

            //We then check if the mediatype already exists
            $mediaType = $this->_em->getRepository("CodeSpanishMyMoviesBundle:Mediatype")
                ->findOneBy(array(
                    'mime'=>'video/webm',
                    'dvd'=>false,
                    'featured'=>false,
                    'small'=>false,
                    'medium'=>false,
                    'large'=>false,
                    'scene'=>false,
                    'trailer'=>true
                ));

            if(empty($mediaType)){
                $mediaType = new Mediatype();
                $mediaType->setMime('video/webm');
                $mediaType->setDvd(false);
                $mediaType->setFeatured(false);
                $mediaType->setSmall(false);
                $mediaType->setMedium(false);
                $mediaType->setLarge(false);
                $mediaType->setScene(false);
                $mediaType->setTrailer(true);
                $this->_em->persist($mediaType);
                $this->_em->flush($mediaType);
            }

            $file=new File();
            $file->setMediatype($mediaType);
            $file->addMovie($movie);
            $file->setSourceurl($url);
            $this->_em->persist($file);
            $this->_em->flush($file);
        }

        return $file;

    }

    /**
     * Retrieves a role object - persist one if none is in the db
     * @param $name
     * @return Role
     */
    public function findRole($name){

        $role= $this->_em->getRepository("CodeSpanishMyMoviesBundle:Role")
            ->findOneBy(array(
                'name'=>$name
            ));

        if(empty($role)){
            $role=new Role();
            $role->setName($name);
            $this->_em->persist($role);
            $this->_em->flush($role);
        }

        return $role;

    }

    /**
     * Finds a person - if not found creates it
     * @param $name
     * @param $id
     * @return Person|null
     */
    public function findPerson($name, $id){

        $person=null;
        $update=false;

        $personRepo=$this->_em->getRepository("CodeSpanishMyMoviesBundle:Person");

        if(isset($id['imdbId']))
            $person=$personRepo->findOneBy(array('imdbid'=>$id['imdbId']));

        if(empty($person)&& isset($id['rottentomatoesId']))
            $person=$personRepo->findOneBy(array('rottentomatoesid'=>$id['rottentomatoesId']));

        if(empty($person)){
            $person=$personRepo->findOneBy(array('fullName'=>$name));
            if(empty($person)){
                $person=new Person();
                $person->setFullName($name);
                $update=true;
            }
        }

        if(isset($id['imdbId']) && $person->getImdbid()==null){
            $person->setImdbid($id['imdbId']);
            $update=true;
        }

        if(isset($id['rottentomatoesId']) && $person->getRottentomatoesid()==null) {
            $person->setRottentomatoesid($id['rottentomatoesId']);
            $update=true;
        }

        if($update){
            $this->_em->persist($person);
            $this->_em->flush($person);
        }

        return $person;
    }

}
