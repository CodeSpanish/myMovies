<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 21/11/2014
 * Time: 5:53 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

class SearchService {

    protected $webRequest;

    public function __construct(WebRequest $webRequest){
        $this->webRequest=$webRequest;
    }

    /**
     * Searches for a movie by title
     * @param $title
     * @throws Exception
     */
    public function getByTitle($title){
        throw new Exception('Not implemented');
    }

    /**
     * Searches for a movie by id
     * @param $id
     * @throws Exception
     */
    public function getById($id){
        throw new Exception('Not implemented');
    }

    /**
     * Gets a page of results
     * @param $page
     * @throws Exception
     */
    public function getPage($page){
        throw new Exception('Not implemented');
    }

    /**
     * Executes the request
     * @param $request
     * @throws Exception
     * @return mixed
     */
    protected function getMovie($request){
        throw new Exception('Not implemented');
    }

    /**
     * Returns movie found message and its data
     * @param $data
     * @param $extraInfo
     * @return mixed
     */
    protected function searchSuccess($data, $extraInfo=array()){

        $message=array(
            'data' => $data,
            'request'=>$this->webRequest->getRequest(),
            'status' => Constants::SUCCESS_CODE,
            'message' => Constants::SUCCESS_MESSAGE
        );

        return json_decode(json_encode(array_merge($message,$extraInfo)));

    }

    /**
     * Returns a movie not found error
     * @param array|null $extraInfo
     * @return mixed
     */
    protected function searchUnsuccessful($extraInfo=array()){

        $message = array(
            'data' => null,
            'request'=>$this->webRequest->getRequest(),
            'status' => Constants::NOT_FOUND_CODE,
            'message' => Constants::NOT_FOUND_MESSAGE
        );

        return (object)(array_merge($message,$extraInfo));

    }

    /**
     * Returns a server error
     * @param array|null $extraInfo
     * @return mixed
     */
    protected function serverError($extraInfo=array()){

        $message = array(
            'data' => null,
            'request'=>$this->webRequest->getRequest(),
            'status' => Constants::UNKNOWN_ERROR_CODE,
            'message' => Constants::UNKNOWN_ERROR_MESSAGE
        );

        return (object) array_merge($message,$extraInfo);
    }

} 