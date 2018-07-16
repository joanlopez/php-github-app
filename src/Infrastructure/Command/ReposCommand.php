<?php

namespace App\Infrastructure\Command;

use App\Application\UseCase\CountWordsUseCase;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReposCommand extends Command
{
    private const NAME = 'repos:words';

    private const ORGANIZATION_LABEL = 'organization';

    private const ORGANIZATION_DESCRIPTION = 'The organization name.';

    private const REPOSITORY_LABEL = 'repo';

    private const REPOSITORY_DESCRIPTION = 'The repository name.';

    /** @var CountWordsUseCase */
    private $countWordsUseCase;

    public function __construct(CountWordsUseCase $countWords)
    {
        parent::__construct(self::NAME);
        $this->countWordsUseCase = $countWords;
    }

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Count the words occurrences')
            ->addArgument(self::ORGANIZATION_LABEL, InputArgument::REQUIRED, self::ORGANIZATION_DESCRIPTION)
            ->addArgument(self::REPOSITORY_LABEL, InputArgument::REQUIRED, self::REPOSITORY_DESCRIPTION);
    }

    /**
     * @throws \App\Application\UseCase\UseCaseWrongParametersException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $organization = $input->getArgument(self::ORGANIZATION_LABEL);
        $repository = $input->getArgument(self::REPOSITORY_LABEL);

        try {
            $wordsCount = $this->countWordsUseCase->do($organization, $repository);
            $table = new Table($output);
            $table->setHeaders(array('Word', '# occurrences'));
            foreach ($wordsCount as $word => $occurrences) {
                $table->addRow([$word, $occurrences]);
            }
            $table->render();
        } catch (GuzzleException $e) {
            $output->writeln([
                'Something was wrong:',
                $e->getMessage()
            ]);
        }
    }
}