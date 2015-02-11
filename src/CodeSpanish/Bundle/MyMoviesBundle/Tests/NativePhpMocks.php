<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 4/12/2014
 * Time: 7:57 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

if(!function_exists('CodeSpanish\Bundle\MyMoviesBundle\Service\curl_init')) {
    function curl_init($url = null)
    {
        return $url;
    }
}

if(!function_exists('CodeSpanish\Bundle\MyMoviesBundle\Service\curl_setopt')) {
    function curl_setopt($param1, $param2, $param3){
        return;
    }
}

if(!function_exists('CodeSpanish\Bundle\MyMoviesBundle\Service\curl_exec')) {
    function curl_exec($request)
    {
        $mocks = new Mocks();

        //WebRequest mocks
        if ($request == '')
                return false;
        if ($request == WebRequest::SOURCE_FORMAT_XML)
            return $mocks->AmazonResults();
        if ($request == WebRequest::SOURCE_FORMAT_JSON)
            return $mocks->WikipediaPage();

        //Amazon mocks
        if(strpos($request,'ecs.amazonaws.ca/onca/xml?AWSAccessKeyId=0AWJP8D8389B9HRTJT02&AWSSecretKey=DAlJKgz8i6YcGx34luI5kAspQwnvS%2F67ztaAcPcN&AssociateTag=iberoamericanmovies-20&Keywords=La%20historia%20oficial&Operation=ItemSearch&ResponseGroup=Large&SearchIndex=DVD&Service=AWSECommerceService')!=false)
            return $mocks->AmazonResults();
        if(strpos($request,'ecs.amazonaws.com/onca/xml?AWSAccessKeyId=0AWJP8D8389B9HRTJT02&AWSSecretKey=DAlJKgz8i6YcGx34luI5kAspQwnvS%2F67ztaAcPcN&AssociateTag=iberoamericanmovies-20&Keywords=Back%20to%20the%20future&Operation=ItemSearch&ResponseGroup=Large&SearchIndex=DVD&Service=AWSECommerceService')!=false)
            return false;

        //Imdb mocks
        if($request=='http://www.myapifilms.com/imdb?format=JSON&filter=M&limit=1&actors=F&trailer=1&awards=1&aka=1&title=Error&exactFilter=1')
            return false;
        if($request=='http://www.myapifilms.com/imdb?format=JSON&filter=M&limit=1&actors=F&trailer=1&awards=1&aka=1&title=La+historia+oficial&exactFilter=1')
            return $mocks->ImdbResults();
        if($request=='http://www.myapifilms.com/imdb?format=JSON&filter=M&limit=1&actors=F&trailer=1&awards=1&aka=1&title=Aballay&exactFilter=0')
            return $mocks->ImdbResultsLooseMatch();
        if($request=='http://www.myapifilms.com/imdb?format=JSON&filter=M&limit=1&actors=F&trailer=1&awards=1&aka=1&title=Not+found&exactFilter=1')
            return $mocks->ImdbResultsNotFound();

        //RottenTomatoes mocks
        if ($request=='http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=nzdpbvnqsj62s3ffs7qhre3w&q=Aballay')
            return $mocks->RottenTomatoesResultsLooseMatch();
        if ($request=='http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=nzdpbvnqsj62s3ffs7qhre3w&q=La+Historia+Oficial')
            return $mocks->RottenTomatoesResults();
        if ($request=='http://api.rottentomatoes.com/api/public/v1.0/movie_alias.json?type=imdb&apikey=nzdpbvnqsj62s3ffs7qhre3w&id=22540')
            return $mocks->RottenTomatoesResults();
        if ($request=='http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=nzdpbvnqsj62s3ffs7qhre3w&q=Aballay')
            return $mocks->RottenTomatoesResultsNotFound();

        //Wikipedia mocks
        if (strpos($request, 'page|error') != false) return false;
        if (strpos($request, 'page|414341434941530a4c41532041434143494153202846494c4d29|35366241') != false) return $mocks->WikipediaPage();
        if (strpos($request, 'page|last-page') != false) return $mocks->WikipediaLastPage();
        if(strpos($request,'cmtitle=Category:Argentine_films&cmcontinue=')!=false) return $mocks->WikipediaPage();

        return false;

    }
}

