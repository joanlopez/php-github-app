<?php

namespace App\Infrastructure\Command;

use App\HttpGuzzleGithubApiClient;
use App\MapWordsCounter;
use App\PascalWordSplitter;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReposCommand extends Command
{
    private const ORGANIZATION_LABEL = 'organization';

    private const ORGANIZATION_DESCRIPTION = 'The organization name.';

    private const REPOSITORY_LABEL = 'repo';

    private const REPOSITORY_DESCRIPTION = 'The repository name.';

    protected function configure()
    {
        $this
            ->setName('repos:words')
            ->setDescription('Count the words occurrences')
            ->addArgument(self::ORGANIZATION_LABEL, InputArgument::REQUIRED, self::ORGANIZATION_DESCRIPTION)
            ->addArgument(self::REPOSITORY_LABEL, InputArgument::REQUIRED, self::REPOSITORY_DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $organization = $input->getArgument(self::ORGANIZATION_LABEL);
        $repository = $input->getArgument(self::REPOSITORY_LABEL);

        $client = new HttpGuzzleGithubApiClient(
            new Client(['headers' => ['Authorization' => 'token '. getenv('GITHUB_AUTH_TOKEN')]]),
            new PascalWordSplitter,
            new MapWordsCounter
        );

        try {
            $data = $client->countRepoWords($organization, $repository);
            $table = new Table($output);
            $table->setHeaders(array('Word', '# occurrences'));
            foreach ($data as $word => $occurrences) {
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