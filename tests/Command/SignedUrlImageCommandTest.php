<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SignedUrlImageCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel      = static::createKernel();
        $application = new Application($kernel);

        $command       = $application->find('phumbor-cli:image:get-url');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command'          => $command->getName(),
                // pass arguments to the helper
                'image'            => 'image',
                '--transformation' => 'default',
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('/unsafe/360x500/image', $output);
    }
}
