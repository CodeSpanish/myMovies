<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 18/11/2014
 * Time: 6:07 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service;

/**
 * Class Amazon Retrieves data from Amazon API
 * Documentation at http://docs.amazonwebservices.com/AWSECommerceService/2010-11-01/DG/
 * @package CodeSpanish\Bundle\MyMoviesBundle\Service
 */
class Amazon extends SearchService {

    protected $webRequest;
    protected $associateTag;
    protected $awsAccessKeyId;
    protected $awsSecretKey;
    protected $locale;

    public function __construct($webRequest, $associateTag,$awsAccessKeyId,$awsSecretKey,$locale){
        $this->webRequest=$webRequest;
        $this->associateTag=$associateTag;
        $this->awsAccessKeyId=$awsAccessKeyId;
        $this->awsSecretKey=$awsSecretKey;
        $this->locale=$locale;
    }

    /**
     * Builds the request
     * @param null $title The title of the movie to search for
     * @return string
     */
    public function getByTitle($title=null)
    {
        //See this link for details http://docs.aws.amazon.com/AWSECommerceService/latest/DG/ItemLookup.html
        $searchArray=array(
            'SearchIndex'=>'DVD',
            'Title'=>$title,
            'ResponseGroup'=>' EditorialReview,ItemAttributes,Images',
            'Operation'=>'ItemSearch'
        );

        //Builds the url
        $request='http://'. $this->setEndPoint() .'/onca/xml'.'?'. $this->canonicalize($this->sign($searchArray));

        //Gets the movie from amazon
        $data=$this->getMovie($request);

        return $data;
    }

    /**
     * Executes the request and builds object
     * @param $request
     * @return array|mixed|string
     */
    protected  function getMovie($request){

        $this->webRequest->setRequest($request);
        $response=$this->webRequest->execute();

        if($response->status==Constants::UNKNOWN_ERROR_CODE) return $this->serverError();
        elseif($response->data->Items->TotalResults=="0")return $this->searchUnsuccessful();
        else return $this->searchSuccess($response->data->Items->Item);
    }

    /**
     * Returns the hostname to Amazon store according to the given country
     * @internal param $locale 2 digit code for the country
     * @return string
     */
    protected  function setEndPoint(){

        switch ($this->locale)
        {
            case 'uk': return Constants::AWS_END_POINT_UK;
            case 'ca': return Constants::AWS_END_POINT_CA;
            case 'fr': return Constants::AWS_END_POINT_FR;
            case 'de': return Constants::AWS_END_POINT_DE;
            case 'jp': return Constants::AWS_END_POINT_JP;
        }

        return Constants::AWS_END_POINT;
    }

    /**
     * Adds a signature to the request
     * @param $params
     * @return mixed
     */
    protected  function sign($params) {

        $params['AssociateTag'] = $this->associateTag;
        $params['AWSAccessKeyId'] = $this->awsAccessKeyId;
        $params['AWSSecretKey']=$this->awsSecretKey;
        $params['Service'] = Constants::AWS_SERVICE;

        // Add a Timestamp to the request.
        $params['Timestamp'] = date("Y-m-d\TH:i:s.000Z");

        // Sort the parameters alphabetically by key
        ksort($params);

        // get the canonical form of the query string
        $canonical = $this->canonicalize($params);

        // construct the data to be signed as specified in the docs
        $stringToSign = 'GET' . "\n" . $this->setEndPoint() . "\n" . '/onca/xml' . "\n" . $canonical;

        // calculate the signature value and add it to the request.
        $params['Signature'] = base64_encode(hash_hmac("sha256", $stringToSign,$params['AWSSecretKey'] , True));
        return $params;
    }

    /**
     * Builds a canonical form of the query string
     * @param $params
     * @return string
     */
    protected  function canonicalize($params) {
        $parts = array();
        foreach( $params as $k => $v){
            $x = rawurlencode($k) . '=' . rawurlencode($v);
            array_push($parts, $x );
        }
        return implode('&',$parts);
    }
}