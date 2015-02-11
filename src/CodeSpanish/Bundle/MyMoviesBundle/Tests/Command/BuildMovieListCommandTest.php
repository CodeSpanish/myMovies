<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 15/11/2014
 * Time: 2:38 PM
 */

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use CodeSpanish\Bundle\MyMoviesBundle\Command\BuildMoviesListCommand;
use CodeSpanish\Bundle\MyMoviesBundle\Service\RottenTomatoes;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Imdb;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Amazon;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Service\MovieManager;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;

/**
 * @property Mocks mocks
 * @property \Symfony\Component\DependencyInjection\ContainerInterface container
 * @property Application application
 * @property  doctrine
 * @property  em
 */
class BuildMovieListCommandTest extends KernelTestCase {

    public function setup(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $this->container=$kernel->getContainer();
        $this->application = new Application($kernel);
        $this->mocks = new Mocks();
        $this->doctrine = $this->container->get('doctrine');
        $this->em = $this->doctrine->getManager();
    }

    public function testExecute(){

        $this->application->add(new BuildMoviesListCommand());

        $command = $this->application->find('my_movies:build:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'country'=>'Argentina',
            'page'=>'page|414341434941530a4c41532041434143494153202846494c4d29|35366241'
            ));

    }

    public function testBuildPopularMovies(){

        $wikipedia = $this->getMockBuilder('CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia')
            ->disableOriginalConstructor()
            ->getMock();

        $wikipedia->method('getPage')->willReturn($this->mocks->Wikipedia_Returns_Popular_Movies());
        $data=$wikipedia->getPage();

        $apiKey = $this->container->getParameter('rottenTomatoesApiKey');
        $rottenTomatoes= new RottenTomatoes(new WebRequest(),$apiKey);

        $imdb=new Imdb(new WebRequest(Constants::MYAPI_IMDB_MOVIE_REQUEST));

        $awsAssociateTag = $this->container->getParameter('awsAssociateTag');
        $awsAccessKeyId=$this->container->getParameter('awsAccessKeyId');
        $awsSecretKey=$this->container->getParameter('awsSecretKey');
        $amazon= new Amazon(
            new WebRequest(Constants::AWS_END_POINT,WebRequest::RESPONSE_FORMAT_OBJECT,WebRequest::SOURCE_FORMAT_XML),
            $awsAssociateTag,
            $awsAccessKeyId,
            $awsSecretKey,
            null);

        $output = $this->getMockBuilder("Symfony\Component\Console\Output\OutputInterface")
            ->disableOriginalConstructor()
            ->getMock();

        $movieManager = new MovieManager(
            $this->em,
            $output,
            array(
                'Wikipedia'=>$wikipedia,
                'RottenTomatoes'=>$rottenTomatoes,
                'Imdb'=>$imdb,
                'Amazon'=>$amazon
            )
        );

        $movieManager->addMovies('Argentina','page|4144494f532050414d5041204d49410a414449c393532050414d5041204dc38d41|8452062');
        $movieManager->updateMovies();

    }


}
 