<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 18/11/2014
 * Time: 8:31 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

/**
 * Class Constants All constants stored here for easy access
 * @package CodeSpanish\Bundle\MyMoviesBundle\Service
 */
class Constants {

    //System messages
    const NOT_FOUND_CODE=100;
    const NOT_FOUND_MESSAGE='Your search retrieve no results.';
    const SUCCESS_CODE=200;
    const SUCCESS_MESSAGE='Success.';
    const UNKNOWN_ERROR_CODE=500;
    const UNKNOWN_ERROR_MESSAGE='Unknown error.';

    //Wikipedia
    const WIKIPEDIA_LIST_REQUEST = 'http://en.wikipedia.org/w/api.php?action=query&list=categorymembers&format=json&cmtitle=';
    const WIKIPEDIA_MOVIE_REQUEST = 'http://en.wikipedia.org/w/api.php?action=query&prop=revisions&rvprop=content&format=json&pageids=';
    const WIKIPEDIA_ARGENTINE_FILMS= 'Category:Argentine_films';
    const WIKIPEDIA_BRAZILIAN_FILMS = 'Category:Brazilian_films';
    const WIKIPEDIA_MEXICAN_FILMS = 'Category:Mexican_films';
    const WIKIPEDIA_SPANISH_FILMS = 'Category:Spanish_films';

    //Amazon
    const AWS_END_POINT='ecs.amazonaws.com';
    const AWS_END_POINT_UK='ecs.amazonaws.co.uk';
    const AWS_END_POINT_CA='ecs.amazonaws.ca';
    const AWS_END_POINT_FR='ecs.amazonaws.fr';
    const AWS_END_POINT_DE='ecs.amazonaws.de';
    const AWS_END_POINT_JP='ecs.amazonaws.jp';
    const AWS_SERVICE ='AWSECommerceService';

    //IMDB
    const IMDB_MOVIE_REQUEST ='http://www.imdb.com/xml/find?json=1&nr=1&tt=on&q=';
    const MYAPI_IMDB_MOVIE_REQUEST= 'http://www.myapifilms.com/imdb?format=JSON&filter=M&limit=1&actors=F&trailer=1&awards=1&aka=1&title=';
    const MYAPI_IMDB_MOVIE_REQUEST_BY_ID='http://www.myapifilms.com/imdb?format=JSON&filter=M&limit=1&actors=F&trailer=1&awards=1&aka=1&idIMDB';

    //ROTTEN TOMATOES
    const ROTTEN_MOVIE_REQUEST='http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=';
    const ROTTEN_MOVIE_REQUEST_BY_ID= 'http://api.rottentomatoes.com/api/public/v1.0/movie_alias.json?type=imdb&apikey=';

    //Youtube
    const YOUTUBE_MOVIE_REQUEST='https://www.googleapis.com/youtube/v3/search?order=relevance&part=snippet&type=video&maxResults=10&videoEmbeddable=true&key=';
    //'https://www.googleapis.com/youtube/v3/search?order=relevance&part=snippet&q=%22The+official+story+trailer%22&type=video&maxResults=10&videoEmbeddable=true&key=AIzaSyCUsE0kFRly88x2V62Z6WdlZH1H_TItUYE';

} 