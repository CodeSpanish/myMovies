<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 22/11/2014
 * Time: 5:13 PM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;
use Google_Client;
use Google_Service_Customsearch;

/**
 * Class Google - executes Google searches
 * See this link for a live demo https://developers.google.com/apis-explorer/#p/customsearch/v1/search.cse.list
 * @package CodeSpanish\Bundle\MyMoviesBundle\Service
 */
class Google extends SearchService
{

    public function __construct(Google_Client $google_Client, $apiKey, $applicationName, $cse_id)
    {
        $this->google_client = $google_Client;
        $this->google_client->setApplicationName($applicationName);
        $this->google_client->setDeveloperKey($apiKey);
        $this->cse_id= $cse_id;
        $this->webRequest = new WebRequest();
    }

    public function getImages($title)
    {

        $search= new Google_Service_Customsearch($this->google_client);
        $results=$search->cse->listCse($title,array(
            'cx'=>$this->cse_id,
            'imgColorType'=>'color',
            'imgSize'=>'medium',
            'imgType'=>'photo',
            'num'=>10,
            'searchType'=>'image',
            'exactTerms'=>$title,
        ))->getItems();

        return $results;

    }


}