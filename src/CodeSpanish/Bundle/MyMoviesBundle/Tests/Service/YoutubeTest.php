<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 16/01/2015
 * Time: 6:48 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Google_Client;
use Google_Http_Batch;
use Google_Service_YouTube;

/**
 * @property WebRequest webRequest
 * @property string youtubeApiKey
 * @property string youtubeAppName
 * @property Google_Client google_client
 * @property Google_Http_Batch google_http_batch
 * @property Google_Service_YouTube google_service_youtube
 */
class YoutubeTest extends KernelTestCase {

    public function setup(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $container =$application->getKernel()->getContainer();

        $this->youtubeApiKey= $container->getParameter('googleapikey');
        $this->youtubeAppName = $container->getParameter('googleappname');
        $this->google_client = new Google_Client();

    }

    public function testGetMovieByTitle_Find_Movie(){

        $youTube = new Youtube(
            $this->google_client,
            $this->youtubeApiKey,
            $this->youtubeAppName
        );
        $response=$youTube->getVideos('Aballay trailer');
        $this->assertContains('Aballay', $response->data[0]->title);
    }

}
