<?php
    /**
     * Created by PhpStorm.
     * User: pmatamoros
     * Date: 24/11/2014
     * Time: 8:58 PM
     */

namespace CodeSpanish\Bundle\MyMoviesBundle\Service {


/**
 * @property string request
 * @property string responseFormat
 * @property string sourceFormat
 */
class WebRequest
{
    const RESPONSE_FORMAT_OBJECT='object';
    const RESPONSE_FORMAT_STRING='string';
    const SOURCE_FORMAT_XML='xml';
    const SOURCE_FORMAT_JSON='json';

    /**
     * @param string $request
     * @param string $responseFormat
     * @param string $sourceFormat
     * @param null $httpsToken
     */
    public function __construct($request='', $responseFormat=self::RESPONSE_FORMAT_OBJECT, $sourceFormat=self::SOURCE_FORMAT_JSON, $httpsToken=null)
    {
        $this->request = $request;
        $this->responseFormat=$responseFormat;
        $this->sourceFormat=$sourceFormat;
        $this->httpsToken=$httpsToken;
    }

    /**
     * @param $request URL and query params to execute
     */
    public function setRequest($request){
        $this->request=$request;
    }

    /**
     * Sets the authorization token for HTTPS requests
     * @param $httpsToken
     */
    public function setAccessToken($httpsToken){
        $this->httpsToken=$httpsToken;
    }

    /**
     * Returns the current request
     * @return string
     */
    public function getRequest(){
        return $this->request;
    }

    /**
     * @param $responseFormat Sets the reponse fomat to object or plain string
     */
    public function setReponseFormat($responseFormat){
        $this->responseFormat=$responseFormat;
    }

    /**
     * @param $sourceFormat Sets the source to json or xml
     */
    public function setSourceFormat($sourceFormat){
        $this->sourceFormat=$sourceFormat;
    }

    public function execute()
    {
        $resource = curl_init($this->request);
        curl_setopt($resource,CURLOPT_RETURNTRANSFER, 1);

        if(isset($this->httpsToken)){
            curl_setopt($resource, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, 0);
            $curlheader[0] = "Authorization: Bearer " . $this->httpsToken;
            curl_setopt($resource, CURLOPT_HTTPHEADER, $curlheader);
        }

        $response = curl_exec($resource);
        $error= curl_error($resource);
        $info = curl_getinfo($resource);

        if ($response == false) {
            return (object) array(
                'data'=>null,
                'request'=>$this->request,
                'status' => _(Constants::UNKNOWN_ERROR_CODE),
                'message'=> _($error)
            );
        }

        if($this->sourceFormat==self::SOURCE_FORMAT_XML){
            if($this->responseFormat==self::RESPONSE_FORMAT_OBJECT)
                $response = json_decode(json_encode(simplexml_load_string($response)));
            if(($this->responseFormat==self::RESPONSE_FORMAT_STRING))
                $response = simplexml_load_string($response);
        }
        elseif($this->sourceFormat==self::SOURCE_FORMAT_JSON){
            if($this->responseFormat==self::RESPONSE_FORMAT_OBJECT)
                $response = json_decode($response);
        }

        return (object) array(
            'data'=>$response,
            'request'=>$this->request,
            'status'=>_(Constants::SUCCESS_CODE),
            'message'=>_(Constants::SUCCESS_MESSAGE)
        );
    }

}
}