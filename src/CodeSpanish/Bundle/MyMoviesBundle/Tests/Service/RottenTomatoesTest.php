<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 20/11/2014
 * Time: 8:25 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

require_once __DIR__.'/../NativePhpMocks.php';


/**
 * @property RottenTomatoes rottenTomatoes
 * @property mixed rottenTomatoesApiKey
 */
class RottenTomatoesTest extends KernelTestCase {

    protected $webRequest;

    public function setup(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $webRequest= new WebRequest();
        $application = new Application($kernel);
        $container =$application->getKernel()->getContainer();

        $this->rottenTomatoesApiKey= $container->getParameter('rottenTomatoesApiKey');

    }

    public function testGetMovieByTitle_Find_Wrong_Movie(){

        $webRequest= new WebRequest();
        $rottenTomatoes = new RottenTomatoes($webRequest,$this->rottenTomatoesApiKey);
        $response=$rottenTomatoes->getByTitle('Aballay');
        $this->assertNotEquals('Aballay',$response->data->title);
    }

    public function testGetMovieByTitle_Find_Exact_Movie(){

        $webRequest= new WebRequest();
        $rottenTomatoes = new RottenTomatoes($webRequest,$this->rottenTomatoesApiKey);
        $response=$rottenTomatoes->getByTitle('La Historia Oficial');
        $this->assertContains('La Historia Oficial',$response->data->title);
    }

    public function testGetMovieById_Can_Find_Movie_By_Id(){

        $webRequest= new WebRequest();
        $rottenTomatoes = new RottenTomatoes($webRequest,$this->rottenTomatoesApiKey);
        $response=$rottenTomatoes->getById('22540');
        $this->assertEquals('22540',$response->data->id);

    }

    public function testGetMovieById_Cannot_Find_Movie_By_Id(){

        $webRequest= new WebRequest();

        $rottenTomatoes = new RottenTomatoes($webRequest,$this->rottenTomatoesApiKey);
        $data=$rottenTomatoes->getById('22541');
        $this->assertEquals(Constants::NOT_FOUND_CODE,$data->status);
    }
}
 