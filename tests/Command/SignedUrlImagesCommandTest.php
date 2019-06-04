<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class SignedUrlImagesCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel      = static::createKernel();
        $application = new Application($kernel);

        $command       = $application->find('phumbor-cli:images:get-url');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command'           => $command->getName(),
                // pass arguments to the helper
                'images'            => ['image1', 'image2'],
                '--transformations' => ['t1', 't2'],
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('/800x600/image1', $output);
        $this->assertStringContainsString('/800x600/image2', $output);
        $this->assertStringContainsString('/1024x800/image1', $output);
        $this->assertStringContainsString('/1024x800/image2', $output);
    }
}
