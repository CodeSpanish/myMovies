<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 12/11/2014
 * Time: 6:52 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

require_once __DIR__.'/../NativePhpMocks.php';

class WikipediaTest extends \PHPUnit_Framework_TestCase {


    public function testGetPage_Connection_Error() {

        $webRequest=new WebRequest(Constants::WIKIPEDIA_LIST_REQUEST,WebRequest::RESPONSE_FORMAT_STRING);
        $wikipedia = new Wikipedia($webRequest);
        $data = $wikipedia->getPage(array('country'=>'Argentina','continue'=>'page|error'));
        $this->assertEquals(Constants::UNKNOWN_ERROR_CODE, $data->status);
    }


    public function testGetPage_Can_Find_Page() {

        $webRequest=new WebRequest(Constants::WIKIPEDIA_LIST_REQUEST,WebRequest::RESPONSE_FORMAT_STRING);
        $wikipedia = new Wikipedia($webRequest);
        $data = $wikipedia->getPage(array('country'=>'Argentina','continue'=>'page|414341434941530a4c41532041434143494153202846494c4d29|35366241'));
        $test=json_encode($data);
        $this->assertEquals(Constants::SUCCESS_CODE, $data->status);
    }

    public function testGetPage_Gets_Last_Page() {

        $webRequest=new WebRequest(Constants::WIKIPEDIA_LIST_REQUEST,WebRequest::RESPONSE_FORMAT_STRING);
        $wikipedia = new Wikipedia($webRequest);
        $data = $wikipedia->getPage(array('country'=>'Argentina','continue'=>'page|last-page'));
        $this->assertEquals(Constants::SUCCESS_CODE, $data->status);
        $this->assertEquals('stop', $data->continue);
    }

}