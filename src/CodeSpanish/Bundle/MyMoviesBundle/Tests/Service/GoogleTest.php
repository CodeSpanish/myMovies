<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 29/01/2015
 * Time: 7:01 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Google_Client;

/**
 * @property Google_Client google_client
 * @property  googleApiKey
 * @property  googleAppName
 * @property  googleSearchId
 */
class GoogleTest extends KernelTestCase {

    protected $googleApiKey;
    protected $googleAppName;
    protected $googleSearchId;

    public function setup(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $container =$application->getKernel()->getContainer();

        $this->googleApiKey = $container->getParameter('googleapikey');
        $this->googleAppName = $container->getParameter('googleappname');
        $this->googleSearchId= $container->getParameter('googleSearchId');
        $this->google_client = new Google_Client();

    }


    public function testGetImage(){

        $google_search=new Google($this->google_client, $this->googleApiKey,$this->googleAppName, $this->googleSearchId);
        $google_search->getImages('La historia oficial scene');
    }

}
