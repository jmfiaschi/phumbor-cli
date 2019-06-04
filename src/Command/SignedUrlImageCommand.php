<?php declare(strict_types=1);

namespace App\Command;

use Jb\Bundle\PhumborBundle\Transformer\BaseTransformer;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to generate signed url image.
 */
final class SignedUrlImageCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var string
     */
    protected static $defaultName = 'phumbor-cli:image:get-url';

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
            ->setDescription('Get signed image url.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to build signed image url with phumbor.')
            ->addArgument('image', InputArgument::REQUIRED, 'Build the image url with this image.')
            ->addOption(
                'transformation',
                't',
                InputOption::VALUE_OPTIONAL,
                'Transformation to apply on the image.',
                'default'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $output->writeln(
            $this->baseTransformer->transform($input->getArgument('image'), $input->getOption('transformation'))
        );

        return 0;
    }
}
