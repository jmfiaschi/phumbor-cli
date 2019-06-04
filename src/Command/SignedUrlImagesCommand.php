<?php declare(strict_types=1);

namespace App\Command;

use Jb\Bundle\PhumborBundle\Transformer\BaseTransformer;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to generate signed image urls and specific transformers.
 */
final class SignedUrlImagesCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    protected static $defaultName = 'phumbor-cli:images:get-url';

    /**
     * @var BaseTransformer
     */
    protected $baseTransformer;

    public function __construct(BaseTransformer $baseTransformer)
    {
        $this->baseTransformer = $baseTransformer;
        $this->logger          = new NullLogger();

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Get signed image urls.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to build signed images url with phumbor.')
            ->addArgument(
                'images',
                InputArgument::REQUIRED | InputArgument::IS_ARRAY,
                'Build the image url with this image.'
            )
            ->addOption(
                'transformations',
                't',
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'List of transformation to apply on the image.',
                ['default']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $signedUrlImageCommand = $this->getApplication()->find('phumbor-cli:image:get-url');

        foreach ($input->getArgument('images') as $image) {
            foreach ($input->getOption('transformations') as $transformation) {
                $signedUrlImageInput = new ArrayInput(
                    [
                        'command'          => 'phumbor-cli:image:get-url',
                        'image'            => $image,
                        '--transformation' => $transformation,
                    ]
                );

                $signedUrlImageCommand->run($signedUrlImageInput, $output);
            }
        }

        return 0;
    }
}
