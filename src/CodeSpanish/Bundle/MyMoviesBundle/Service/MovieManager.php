<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 18/11/2014
 * Time: 5:21 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Entity\Cast;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Country;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\File;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Movie;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Person;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\Role;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr;

/**
 * @property \Doctrine\ORM\EntityManager entityManager
 * @property \Symfony\Component\Console\Output\OutputInterface outputInterface
 * @property \CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia wikipedia
 * @property \CodeSpanish\Bundle\MyMoviesBundle\Service\RottenTomatoes rottenTomatoes
 * @property \CodeSpanish\Bundle\MyMoviesBundle\Service\Imdb imdb
 * @property \CodeSpanish\Bundle\MyMoviesBundle\Service\Amazon amazon
 */
class MovieManager {

    /**
     * @param EntityManager $entityManager
     * @param OutputInterface $output
     * @param array $services
     */
    public function __construct(EntityManager $entityManager,OutputInterface $output, $services=array()){

        $this->entityManager= $entityManager;
        $this->outputInterface=$output;
        if(isset($services['Wikipedia'])) $this->wikipedia=$services['Wikipedia'];
        if(isset($services['RottenTomatoes'])) $this->rottenTomatoes=$services['RottenTomatoes'];
        if(isset($services['Imdb'])) $this->imdb=$services['Imdb'];
        if(isset($services['Amazon'])) $this->amazon=$services['Amazon'];

        $this->movieRepo=$this->entityManager->getRepository('CodeSpanishMyMoviesBundle:Movie');
        $this->castRepo=$this->entityManager->getRepository('CodeSpanishMyMoviesBundle:Cast');

    }

    /**
     * Updates the full list of movies for a given country
     * @param $country
     * @param string $page
     * @return mixed
     */
    public function addMovies($country, $page=''){

        $continue=null;
        $list = array();
        $i=0;

        while($continue!='stop' && $continue!='error'){

            if(isset($page)) $continue=$page;

            $list=$this->wikipedia->getPage(array('country'=>$country,'continue'=>$continue));

            //Creates the records on a successful response
            if($list->status==200){
                $continue = $list->continue;

                foreach($list->data as $movie){
                    $this->addMovie($movie);
                }

            }

            //Stops if a single page was requested or an error occurred
            if($list->status==Constants::UNKNOWN_ERROR_CODE) return $this->serverError();
            if(isset($page)) $continue='stop';

        }

        return $this->updateSuccess($list->data);
    }

    /**
     * Loops through all the webservices to consolidate movie data and create actors, etc.
     */
    public function updateMovies(){

        $movies= $this->movieRepo->findAll();

        foreach($movies as $listedMovie){

            $this->updateRottenTomatoesData($listedMovie);
            $this->outputInterface->writeln("Updated RottenTomatoes data: ". $listedMovie->getOriginalTitle());

            $this->updateImdbData($listedMovie);
            $this->outputInterface->writeln("Updated Imdb data: ". $listedMovie->getOriginalTitle());

            $this->updateAmazonData($listedMovie);
            $this->outputInterface->writeln("Updated Amazon data: ". $listedMovie->getOriginalTitle());

            $this->entityManager->merge($listedMovie);
            $this->entityManager->flush($listedMovie);

            }
        }

    /**
     * Retrieves RottenTomatoes data and updates the movies
     * @param Movie $movie
     * @return null
     */
    protected function updateRottenTomatoesData(&$movie){

        if($movie->getRottentomatoesId()!=null) {
            $response = $this->rottenTomatoes->getById($movie->getRottentomatoesId());
        }
        else {
            $response = $this->rottenTomatoes->getByTitle($movie->getOriginalTitle());
        }

        if($response->status==Constants::SUCCESS_CODE){

            if(empty($movie->getRottentomatoesId())) $movie->setRottentomatoesId($response->data->id);
            if(empty($movie->getEnglishTitle())) $movie->setEnglishTitle($response->data->title);
            if(empty($movie->getOriginalTitle())) $movie->setOriginalTitle($response->data->title);
            if(empty($movie->getRuntime())) $movie->setRuntime($response->data->runtime);
            if(empty($movie->getYear())) $movie->setYear($response->data->year);
            if(empty($movie->getStoryline())) $movie->setStoryline($response->data->synopsis);

            $this->updateCast($movie,$response->data->abridged_cast,'actor');

        }

        return;

    }

    /**
     * Retrieves IMDB data and updates movies
     * @param Movie $movie
     * @return null
     */
    protected function updateImdbData(&$movie){

        if($movie->getImdbId()!=null)
        {
            $response= $this->imdb->getById($movie->getImdbId());
        }
        else
        {
            $response= $this->imdb->getByTitle($movie->getOriginalTitle());
        }

        if($response->status==Constants::SUCCESS_CODE) {

            /* Todo
                * $response->data->genres[0]
                * $response->data->awards
            */

            if (empty($movie->getEnglishTitle())) $movie->setEnglishTitle($response->data->title);
            if ($movie->getOriginalTitle()!=$response->data->akas[0]->title) $movie->setOriginalTitle($response->data->akas[0]->title);
            if (empty($movie->getYear())) $movie->setYear($response->data->year);
            if (empty($movie->getStoryline())) $movie->setStoryline($response->data->plot);
            if (empty($movie->getImdbId())) $movie->setImdbId($response->data->idIMDB);

            if(empty($movie->getCountry())){
                foreach($movie->data->countries as $country){
                    $country=$this->movieRepo->findCountry($country);
                    $movie->addCountry($country);
                }
            }

            $this->updateCast($movie,$response->data->actors,'actor');
            $this->updateCast($movie,$response->data->writers,'writer');
            $this->updateCast($movie,$response->data->directors,'director');
        }

        return;
    }

    /**
     * Retrieves Amazon data and updates movies
     * @param Movie $movie
     * @throws Exception
     */
    protected function updateAmazonData(&$movie){

        if($movie->getAmazonId()!=null) return;

        $response= $this->amazon->getByTitle($movie->getOriginalTitle());

        if($response->status==Constants::SUCCESS_CODE) {

            if(!is_object($response->data)){
                $response->data=$response->data[0];
            }

            //Often returns random data - we make sure it is the right movie
            $match= strpos($response->data->ItemAttributes->Title,$movie->getOriginalTitle());
            if($match==0){

                if (empty($movie->getAmazonId())) $movie->setAmazonId($response->data->ASIN);
                if (empty($movie->getEnglishTitle())) $movie->setEnglishTitle($response->data->ItemAttributes->Title);
                if (empty($movie->getRuntime())) $movie->setRuntime($response->data->ItemAttributes->RunningTime);
                if (empty($movie->getStoryline()))$movie->setStoryline($response->data->EditorialReviews->EditorialReview->Content);

                if(isset($response->data->ItemAttributes->Actor))
                    $this->updateCast($movie,$response->data->ItemAttributes->Actor,'actor');

                if(isset($response->data->ItemAttributes->Director)){
                    $director=(object)array('name'=>$response->data->ItemAttributes->Director);
                    $this->updateCast($movie,$director,'director');
                }

                $this->movieRepo->findDvdCover($movie,$response->data->SmallImage->URL,'s');
                $this->movieRepo->findDvdCover($movie,$response->data->MediumImage->URL,'m');
                $this->movieRepo->findDvdCover($movie,$response->data->LargeImage->URL,'l');

            }
        }

/*
    * http://www.amazon.com/dp/B008J7QNZW/?tag=iberoamericanmovies-20
    * $data->data->ItemAttributes->Actor
 * $data->data->ItemAttributes->RunningTime
 * $data->data->ItemAttributes->AudienceRating
 * $data->data->ItemAttributes->Director
 * $data->data->CustomerReviews->IFrameURL
 * $data->data->LargeImage->URL
 * $data->data->MediumImage->URL
 * $data->data->SmallImage->URL
 * $data->data->SalesRank
 * $data[0]->ItemAttributes->Title;
 * $response->data[0]->EditorialReviews->EditorialReview->Content;
 */


    }

    protected function updateCast(&$movie, $people, $role){

        if(!is_array($people)){
            if(is_string($people)) $people = str_getcsv($people,',');
        }

        foreach ($people as $castMember) {

            switch ($role){

                case 'actor':
                    $roleEntity=$this->movieRepo->findRole('actor');

                    if(isset($castMember->id))
                        $person = $this->movieRepo->findPerson($castMember->name, array('rottentomatoesId'=>$castMember->id));

                    if(isset($castMember->actorId))
                        $person = $this->movieRepo->findPerson($castMember->actorName, array('imdbId'=>$castMember->actorId));

                    if(!isset($castMember->id) && !isset($castMember->actorId))
                        $person = $this->movieRepo->findPerson($castMember, array(null));

                    break;

                case 'director':
                    $roleEntity=$this->movieRepo->findRole('director');

                    if(isset($castMember->nameId)){
                        $person = $this->movieRepo->findPerson($castMember->name, array('imdbId'=>$castMember->nameId));
                    }

                    if(!isset($castMember->nameId) && isset($castMember->name)){
                        $person = $this->movieRepo->findPerson($castMember->name, null);
                    }

                    if(!isset($castMember->nameId) && !isset($castMember->name)){
                        $person = $this->movieRepo->findPerson($castMember, array(null));
                    }

                    break;

                case 'writer':
                    $roleEntity=$this->movieRepo->findRole('writer');
                    $person = $this->movieRepo->findPerson($castMember->name, array('imdbId'=>$castMember->nameId));
                    break;
            };

            $castMovie = $this->movieRepo->findCastMember($person,$roleEntity,$movie);

        }

    }

    /**
     * Persist the movie in the database
     * @param $movie
     */
    protected  function addMovie($movie){

        $myMovie=$this->movieRepo->findBy(array("wikipediaId"=>$movie->pageid));

        if(empty($myMovie)){

            $title = $this->fixTitle($movie->title);

            $myMovie = new Movie();
            $myMovie->setWikipediaId($movie->pageid);
            $myMovie->setOriginalTitle($title);
            $myMovie->setEnglishTitle($title);
            $this->entityManager->persist($myMovie);
            $this->entityManager->flush($myMovie);
            $this->outputInterface->writeln("Saved: ".$title);
        }

    }

    /**
     * Fixes titles that include expressions like '(2010 film)' or '(film)'
     * @param $title
     * @return mixed
     */
    protected function fixTitle($title){

        $expressions= array(
            '(\(\d{4} film\))',
            '(\(film\))'
        );

        foreach($expressions as $regex){

            preg_match ( $regex , $title, $matches);
            if(!empty($matches)){
                return str_replace($matches,'',$title);
            }

        }

        return $title;
    }

    /**
     * @param array $extraInfo
     * @return mixed
     */
    protected function serverError($extraInfo=array()){

        $message = array(
            'data' => null,
            'status' => Constants::UNKNOWN_ERROR_CODE,
            'message' => Constants::UNKNOWN_ERROR_MESSAGE
        );

        return json_decode(json_encode(array_merge($message,$extraInfo)));
    }

    /**
     * Returns movie found message and its data
     * @param $data
     * @param $extraInfo
     * @return mixed
     */
    protected function updateSuccess($data, $extraInfo=array()){

        $message=array(
            'data' => $data,
            'status' => Constants::SUCCESS_CODE,
            'message' => Constants::SUCCESS_MESSAGE
        );

        return json_decode(json_encode(array_merge($message,$extraInfo)));

    }

}