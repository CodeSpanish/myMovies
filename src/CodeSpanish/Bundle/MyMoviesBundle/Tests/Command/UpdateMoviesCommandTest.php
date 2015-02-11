<?php
/**
 * Created by PhpStorm.
 * User: pmatamoros
 * Date: 9/12/2014
 * Time: 6:43 AM
 */

namespace CodeSpanish\Bundle\MyMoviesBundle\Command;

use CodeSpanish\Bundle\MyMoviesBundle\Entity\Mediatype;
use CodeSpanish\Bundle\MyMoviesBundle\Service\MovieManager;
use CodeSpanish\Bundle\MyMoviesBundle\Tests\Mocks;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use CodeSpanish\Bundle\MyMoviesBundle\Service\WebRequest;
use CodeSpanish\Bundle\MyMoviesBundle\Command\UpdateMoviesCommand;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Constants;
use CodeSpanish\Bundle\MyMoviesBundle\Service\Amazon;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * @property Application application
 * @property mixed container
 * @property Mocks mocks
 */
class UpdateMoviesCommandTest extends KernelTestCase {

    public function setup(){

        $kernel = $this->createKernel();
        $kernel->boot();

        $this->container=$kernel->getContainer();
        $this->application = new Application($kernel);
        $this->mocks = new Mocks();

}

    public function testExecute(){

        $this->application->add(new UpdateMoviesCommand());

        $command = $this->application->find('my_movies:update:movies');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array());

    }

}
 