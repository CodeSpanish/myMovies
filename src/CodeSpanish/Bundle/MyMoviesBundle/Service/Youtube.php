<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 15/01/2015
 * Time: 7:16 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;
use Google_Client;
use Google_Service_YouTube;

class Youtube extends SearchService {

    public function __construct(Google_Client $google_Client, $apiKey, $applicationName){

        $this->google_client=$google_Client;
        $this->google_client->setApplicationName($applicationName);
        $this->google_client->setDeveloperKey($apiKey);
        $this->webRequest=new WebRequest();
    }

    /**
     * @param $title
     * @return mixed
     */
    public function getVideos($title){

        $google_service_youtube = new Google_Service_YouTube($this->google_client);
        $data=$google_service_youtube->search->listSearch(
            'snippet',
            array(
                'type'=>'video',
                'maxResults'=>5,
                'videoEmbeddable'=>'true',
                'q'=>$title
            )
        );

        if(!$data->valid()) return $this->serverError();

        $videos= array();
        foreach($data->getItems() as $video){
            array_push($videos, array(
               'videoId'=>$video['modelData']['id']['videoId'],
               'title' =>$video['modelData']['snippet']['title'],
               'url'=>'http://www.youtube.com/embed/'.$video['modelData']['id']['videoId']
            ));
        };

        return $this->searchSuccess($videos);

    }

}