<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 24/11/2014
 * Time: 9:28 PM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;

require_once __DIR__.'/../NativePhpMocks.php';


/**
 * @property Mocks mocks
 */
class WebRequestTest extends \PHPUnit_Framework_TestCase {

    const JSON_TEST='http://en.wikipedia.org/w/api.php?action=query&list=categorymembers&format=json&cmtitle=Category:Argentine_films';
    const XML_TEST='http://en.wikipedia.org/w/api.php?action=query&list=categorymembers&format=xml&cmtitle=Category:Argentine_films';

    protected $sourceFormat;

    public function  setup(){
        $this->mocks=new Mocks();
    }

    public function testExecute_Can_Return_Object_From_Json(){
        $webRequest = new WebRequest(WebRequest::SOURCE_FORMAT_JSON,WebRequest::RESPONSE_FORMAT_OBJECT, WebRequest::SOURCE_FORMAT_JSON);
        $response = $webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE,$response->status);
    }

    public function testExecute_Can_Return_String_From_Json(){
        $webRequest = new WebRequest(WebRequest::SOURCE_FORMAT_JSON,WebRequest::RESPONSE_FORMAT_STRING, WebRequest::SOURCE_FORMAT_JSON);
        $response = $webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE,$response->status);
    }

    public function testExecute_Can_Return_Object_From_XML()
    {
        $webRequest = new WebRequest(WebRequest::SOURCE_FORMAT_XML,WebRequest::RESPONSE_FORMAT_OBJECT,WebRequest::SOURCE_FORMAT_XML);
        $response = $webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE, $response->status);
    }

    public function testExecute_Can_Return_String_From_Xml(){
        $webRequest = new WebRequest(WebRequest::SOURCE_FORMAT_XML,WebRequest::SOURCE_FORMAT_XML,WebRequest::RESPONSE_FORMAT_STRING);
        $response = $webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE,$response->status);
    }

    public function testExecute_Returns_Error(){
        $webRequest = new WebRequest('');
        $this->assertEquals(Constants::UNKNOWN_ERROR_CODE,$webRequest->execute()->status);
    }

    public function testExecute_Can_Set_Request(){
        $webRequest = new WebRequest();
        $webRequest->setRequest(WebRequest::SOURCE_FORMAT_JSON);
        $webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE,$webRequest->execute()->status);
    }

    public function testExecute_Can_Set_Response_Format(){
        $webRequest = new WebRequest();
        $webRequest->setRequest(WebRequest::SOURCE_FORMAT_JSON);
        $webRequest->setReponseFormat(WebRequest::RESPONSE_FORMAT_STRING);
        $data=$webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE,$data->status);
    }

    public function testExecute_Can_Set_Source_Format(){
        $webRequest = new WebRequest();
        $webRequest->setRequest(WebRequest::SOURCE_FORMAT_JSON);
        $webRequest->setSourceFormat(WebRequest::RESPONSE_FORMAT_OBJECT);
        $data=$webRequest->execute();
        $this->assertEquals(Constants::SUCCESS_CODE,$data->status);
    }
}