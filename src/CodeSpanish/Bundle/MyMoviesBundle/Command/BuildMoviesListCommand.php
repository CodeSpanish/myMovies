<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 15/11/2014
 * Time: 2:02 PM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Command;

use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Service\MovieManager;
use CodeSpanish\Bundle\MyMoviesBundle\Service\RottenTomatoes;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Wikipedia;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class BuildMoviesListCommand Command to execute an update of the MoviesList
 * @package CodeSpanish\Bundle\MyMoviesBundle\Command
 */
class BuildMoviesListCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('my_movies:build:list')
            ->setDescription('Builds a list of movies to process')
            ->addArgument('country', InputArgument::REQUIRED, 'Country to build the list for.')
            ->addArgument('page', InputArgument::OPTIONAL, 'Page to update.')
        ;
    }

    /**
     * Executes a full update of the MoviesList table
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine= $this->getContainer()->get('doctrine')->getManager();
        $country = $input->getArgument('country');
        $page = $input->getArgument('page');

        $wikipedia = new Wikipedia(new WebRequest('',WebRequest::RESPONSE_FORMAT_STRING));

        $apiKey = $this->getContainer()->getParameter('rottenTomatoesApiKey');
        $rottenTomatoes= new RottenTomatoes(new WebRequest(),$apiKey);

        $movieManager = new MovieManager(
            $doctrine,
            $output,
            array(
                'Wikipedia'=>$wikipedia,
                'RottenTomatoes'=>$rottenTomatoes
            )
        );

        $output->writeln('Updating list');
        $movieManager->addMovies($country,$page);
        $output->writeln('List updated.');
    }

} 