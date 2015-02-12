<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 9/12/2014
 * Time: 6:33 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Command;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Amazon;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Imdb;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Youtube;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CodeSpanish\Bundle\MyMoviesBundle\Service\MovieManager;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Service\RottenTomatoes;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Google;
use Google_Client;

class UpdateMoviesCommand extends ContainerAwareCommand {

    protected  function configure(){
        $this
            ->setName('my_movies:update:movies')
            ->setDescription('Updates the movies available in the movies list.')
/*
            ->addArgument('country', InputArgument::REQUIRED, 'Country to build the list for.')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page to update.')
*/
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $doctrine= $this->getContainer()->get('doctrine')->getManager();

        $wikipedia = new Wikipedia(new WebRequest('',WebRequest::RESPONSE_FORMAT_STRING));

        $apiKey = $this->getContainer()->getParameter('rottenTomatoesApiKey');
        $rottenTomatoes= new RottenTomatoes(new WebRequest(),$apiKey);

        $imdb=new Imdb(new WebRequest(Constants::MYAPI_IMDB_MOVIE_REQUEST));

        $awsAssociateTag = $this->getContainer()->getParameter('awsAssociateTag');
        $awsAccessKeyId=$this->getContainer()->getParameter('awsAccessKeyId');
        $awsSecretKey=$this->getContainer()->getParameter('awsSecretKey');
        $amazon= new Amazon(
            new WebRequest(Constants::AWS_END_POINT,WebRequest::RESPONSE_FORMAT_OBJECT,WebRequest::SOURCE_FORMAT_XML),
            $awsAssociateTag,
            $awsAccessKeyId,
            $awsSecretKey,
            null);

        $googleApiKey = $this->getContainer()->getParameter('googleapikey');
        $googleAppName = $this->getContainer()->getParameter('googleappname');
        $googleSearchId= $this->getContainer()->getParameter('googleSearchId');
        $google_client = new Google_Client();
        $google_search = new Google($google_client, $googleApiKey,$googleAppName, $googleSearchId);

        $youtube = new Youtube($google_client,$googleApiKey,$googleAppName);

        $movieManager = new MovieManager(
            $doctrine,
            $output,
            array(
                'Wikipedia'=>$wikipedia,
                'RottenTomatoes'=>$rottenTomatoes,
                'Imdb'=>$imdb,
                'Amazon'=>$amazon,
                'Youtube'=>$youtube,
                'Google'=>$google_search
            )
        );

        $output->writeln('Updating movies');
        $movieManager->updateMovies();
        $output->writeln('Movies updated.');

    }

} 