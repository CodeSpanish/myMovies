<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 10/11/2014
 * Time: 6:34 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;


/**
 * This class executes an HTTP request to Wikipedia API
 * @package CodeSpanish\Bundle\MyMoviesBundle\Service
 * @property WebRequest webRequest
 */
class Wikipedia extends SearchService
{

    /**
     * @param WebRequest $webRequest
     */
    public function __constructor(WebRequest $webRequest){
        $this->webRequest=$webRequest;
    }

    /**
     * Gets a page of the list of movies for a given country
     * @param array $page
     * @internal param $country
     * @internal param null $continue
     * @return mixed
     */
    public function getPage($page=array('country'=>'Argentina','continue'=>''))
    {
        $category = $this->getCategory($page['country']);
        $request = Constants::WIKIPEDIA_LIST_REQUEST . $category . '&cmcontinue=' . $page['continue'];
        $response=$this->getData($request);

        if ($response->status==Constants::UNKNOWN_ERROR_CODE) return $this->serverError(array('continue'=>'error'));

        if(isset($response->data->continue->categorymembers->cmcontinue))
            return $this->searchSuccess(
                $response->data->query->categorymembers,
                array('continue' => $response->data->continue->categorymembers->cmcontinue)
            );
        else return $this->searchSuccess(
            $response->data->query->categorymembers,
            array('continue' => 'stop')
        );
    }

    /**
     * Returns the category parameter to use in the request for a given country
     * @param $country
     * @return null|string
     */
    protected function  getCategory($country)
    {
        switch (strtoupper($country)) {
            case "ARGENTINA": return Constants::WIKIPEDIA_ARGENTINE_FILMS;
            case "BRAZIL":
            case "BRASIL": return Constants::WIKIPEDIA_BRAZILIAN_FILMS;
            case "MEXICO": return Constants::WIKIPEDIA_MEXICAN_FILMS;
            case "SPAIN": return Constants::WIKIPEDIA_SPANISH_FILMS;
            default: return Constants::WIKIPEDIA_ARGENTINE_FILMS;
        }

        return null;
    }

    /**
     * Executes the request and fixes issue with Json format
     * @param $request
     * @return mixed An object with a list of movies
     */
    protected function getData($request)
    {
        $this->webRequest->setRequest($request);
        $response = $this->webRequest->execute();
        $response->data = json_decode(str_replace('query-continue','continue',$response->data));

        return $response;
    }
}

