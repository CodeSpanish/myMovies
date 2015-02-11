<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 18/11/2014
 * Time: 8:42 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;


class Imdb extends SearchService
{
    protected $webRequest;

    public function __construct(WebRequest $webRequest){
        $this->webRequest=$webRequest;
    }

    /**
     * Find a movie by title in IMDB.com - Builds the request
     * @param null $title
     * @param $exactFilter
     * @return mixed
     */
    public function getByTitle($title = null, $exactFilter = 0)
    {
        $request = Constants::MYAPI_IMDB_MOVIE_REQUEST . urlencode($title) . '&exactFilter=' . $exactFilter;
        $data = $this->getMovie($request);
        return $data;
    }

    /**
     * Builds a request to get movies by their id
     * @param null $id
     * @return mixed|void
     */
    public function getById($id=null){
        $request=Constants::MYAPI_IMDB_MOVIE_REQUEST.urlencode($id);
        $data=$this->getMovie($request);
        return $data;
    }

    /**
     * Find a movie by title in IMDB.com - Executes the request
     * @param $request
     * @return mixed
     */
    protected function getMovie($request) {

        $this->webRequest->setRequest($request);
        $response = $this->webRequest->execute();

        //Connection or server error
        if ($response->status==Constants::UNKNOWN_ERROR_CODE) return $this->serverError();

        if (!isset($response->data->code)) return $this->searchSuccess($response->data[0]);
        else return $this->searchUnsuccessful();

    }

} 