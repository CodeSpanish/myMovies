<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 20/11/2014
 * Time: 8:13 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

/**
 * Class RottenTomatoes
 * @package CodeSpanish\Bundle\MyMoviesBundle\Service
 * @property WebRequest webRequest
 */
class RottenTomatoes extends SearchService {

    protected $apiKey;

    /**
     * @param WebRequest $webRequest
     * @param $apiKey
     */
    public function __construct(WebRequest $webRequest,$apiKey){
        $this->apiKey=$apiKey;
        $this->webRequest=$webRequest;
    }

    /**
     * Finds a movie by id - Builds request
     * @param $id
     * @return mixed
     */
    public function getById($id){
        $request = Constants::ROTTEN_MOVIE_REQUEST_BY_ID.$this->apiKey.'&id='. urlencode($id);
        return $this->getMovie($request);
    }

    /**
     * Finds a movie by title - Builds request
     * @param $title
     * @return mixed
     */
    public function getByTitle($title){
        $request = Constants::ROTTEN_MOVIE_REQUEST.$this->apiKey.'&q='. urlencode($title);
        return $this->getMovie($request);
    }

    /**
     * Executes the request and builds object
     * @param $request
     * @return mixed
     */
    protected  function getMovie($request)
    {
        $this->webRequest->setRequest($request);
        $data = $this->webRequest->execute();

        if (!isset($data)) return $this->serverError();

        //Checks for id search errors
        if(isset($data->error)) return $this->serverError();

        if (isset($data->data->id)) return $this->searchSuccess($data);
        elseif(isset($data->data->total)) {
            if($data->data->total>0) return $this->searchSuccess($data->data->movies[0]);
            else return $this->searchUnsuccessful();
        }

        return $this->searchUnsuccessful();

    }

}