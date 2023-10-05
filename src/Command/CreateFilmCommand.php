<?php

namespace App\Command;

use App\Controller\FilmsController;
use App\Service\OmdbApiConsumer;
use App\Service\SaveApiFilmService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create:film',
    description: 'Commande permettant de créer un film',
)]
class CreateFilmCommand extends Command
{

    public function __construct(private SaveApiFilmService $saveService, private OmdbApiConsumer $omdb)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Nom du film')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');
        if ($name) {
            $io->success('Arguments récupérés');
            $data = $this->omdb->getInfos($name)->getContent();
            $io->success('Film récupéré depuis l\'api');
            $this->saveService->saveFilm($data);
            $io->success('Film ajouté dans la base de données');
            return Command::SUCCESS;
        }
    }
}
