<?php

declare(strict_types=1);

namespace App\Manticore\Command;

use App\Manticore\Service\ManticoreService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateCommand extends Command
{
    public function __construct(
        private readonly ManticoreService $manticoreService,
    ) {
        parent::__construct();
    }

    #[\Override]
    protected function configure(): void
    {
        $this->setName('app:manticore:populate');
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->manticoreService->deleteTables();
        $this->manticoreService->createTables();
        $this->manticoreService->populate();

        return Command::SUCCESS;
    }
}
