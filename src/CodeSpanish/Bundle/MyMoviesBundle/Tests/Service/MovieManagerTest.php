<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 20/11/2014
 * Time: 6:38 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

require_once __DIR__.'/../NativePhpMocks.php';

/**
 * @property Mocks mocks
 * @property mixed entityManager
 * @property mixed output
 */
class MovieManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup for mocks
     */
    public function setup()
    {
        $this->mocks = new Mocks();

        $this->entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->output = $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->disableOriginalConstructor()
            ->getMock();

    }

    public function testUpdateMoviesList_Returns_Error()
    {
        $webRequest = $this->getMockBuilder('CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $wikipedia = $this->getMockBuilder('CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia')
            ->setConstructorArgs(array(
                'webRequest'=>$webRequest
            ))
            ->setMethods(null)
            ->getMock();

        $movieManager = $this->getMockBuilder('CodeSpanish\Bundle\MyMoviesBundle\Service\MovieManager')
            ->setConstructorArgs(array(
                'entityManager' => $this->entityManager,
                'output' => $this->output,
                'services' => array('Wikipedia' => $wikipedia)
            ))
            ->setMethods(null)
            ->getMock();

        $webRequest->method('execute')->willReturn($this->mocks->ConnectionError());

        $data = $movieManager->updateMoviesList('Argentina', '');
        $this->assertEquals(Constants::UNKNOWN_ERROR_CODE, $data->status);

    }

    public function testUpdateMoviesList_Returns_First_Page()
    {
        $webRequest=new WebRequest(Constants::WIKIPEDIA_LIST_REQUEST,WebRequest::RESPONSE_FORMAT_STRING);

        $wikipedia = $this->getMockBuilder('CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia')
            ->setConstructorArgs(array(
                'webRequest'=>$webRequest
            ))
            ->setMethods(null)
            ->getMock();

        $movieManager = $this->getMockBuilder('CodeSpanish\Bundle\MyMoviesBundle\Service\MovieManager')
            ->setConstructorArgs(array(
                'entityManager' => $this->entityManager,
                'output' => $this->output,
                'services' => array('Wikipedia' => $wikipedia)
            ))
            ->setMethods(null)
            ->getMock();

        $data = $movieManager->updateMoviesList('Argentina');

        $this->assertEquals(Constants::SUCCESS_CODE,$data->status);
    }

}

 