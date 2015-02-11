<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 18/11/2014
 * Time: 5:58 PM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Imdb;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

require_once __DIR__.'/../NativePhpMocks.php';

class ImdbTest extends \PHPUnit_Framework_TestCase {

    protected $webRequest;

    public function test_GetMovieByTitle_Connection_Error() {

        $this->webRequest=new WebRequest('');
        $imdb = new Imdb($this->webRequest);
        $response = $imdb->getByTitle('Error',1);
        $this->assertEquals(Constants::UNKNOWN_ERROR_CODE,$response->status);
    }


    public function test_GetMovieByTitle_Can_Find_Exact_Movie_Match() {

        $this->webRequest=new WebRequest('');
        $imdb = new Imdb($this->webRequest);
        $response = $imdb->getByTitle('La historia oficial',1);
        $this->assertEquals(Constants::SUCCESS_CODE,$response->status);
    }

    public function test_GetMovieByTitle_Cannot_Find_Exact_Movie_Match() {

        $this->webRequest= new WebRequest(Constants::IMDB_MOVIE_REQUEST);
        $imdb = new Imdb($this->webRequest);
        $response = $imdb->getByTitle('Not found',1);
        $this->assertEquals(Constants::NOT_FOUND_CODE,$response->status);

    }

    public function test_GetMovieByTitle_Can_Find_Loose_Movie_Match() {

        $this->webRequest=new WebRequest(Constants::IMDB_MOVIE_REQUEST);
        $imdb = new Imdb($this->webRequest);
        $response = $imdb->getByTitle('Aballay');
        $this->assertNotEquals('Aballay',$response->data->title);

    }
}
 