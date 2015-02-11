<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 18/11/2014
 * Time: 6:24 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Amazon;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

require_once __DIR__.'/../NativePhpMocks.php';

class AmazonTest extends KernelTestCase {

    protected $associateTag;
    protected $awsAccessKeyId;
    protected $awsSecretKey;
    protected $webRequest;

    /**
     * @var Mocks
     */
    protected $mocks;

    public function setup(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $container =$application->getKernel()->getContainer();

        $this->associateTag= $container->getParameter('awsAssociateTag');
        $this->awsAccessKeyId=$container->getParameter('awsAccessKeyId');
        $this->awsSecretKey=$container->getParameter('awsSecretKey');

        $this->mocks=new Mocks();
    }


    public function testGetMovieByTitle_Can_Find_Movie(){

        $webRequest = new WebRequest(Constants::AWS_END_POINT_CA,WebRequest::RESPONSE_FORMAT_OBJECT,WebRequest::SOURCE_FORMAT_XML);
        $amazon = new Amazon($webRequest, $this->associateTag,$this->awsAccessKeyId,$this->awsSecretKey,'ca');
        $data=$amazon->getByTitle('La historia oficial');
        $this->assertEquals(Constants::SUCCESS_CODE,$data->status);

    }

    public function testGetMovieByTitle_ConnectionError(){

        $webRequest = new WebRequest('',WebRequest::RESPONSE_FORMAT_OBJECT,WebRequest::SOURCE_FORMAT_XML);

        $amazon = new Amazon($webRequest,$this->associateTag,$this->awsAccessKeyId,$this->awsSecretKey,null);
        $data=$amazon->getByTitle('Back to the future');
        $this->assertEquals(Constants::UNKNOWN_ERROR_CODE,$data->status);

    }


}
