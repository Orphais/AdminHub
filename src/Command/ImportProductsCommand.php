<?php

namespace App\Command;

use App\Service\ProductCsvImportService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:import-products',
    description: 'Importe des produits depuis un fichier CSV placé dans le dossier public/',
)]
class ImportProductsCommand extends Command
{
    public function __construct(
        private ProductCsvImportService $csvImportService,
        #[Autowire('%kernel.project_dir%/public')]
        private string $publicDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('filename', InputArgument::OPTIONAL, 'Nom du fichier CSV dans public/', 'products.csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filename = $input->getArgument('filename');
        $filePath = $this->publicDir . '/' . $filename;

        $io->title('Importation des produits');
        $io->text("Fichier : $filePath");

        try {
            $result = $this->csvImportService->import($filePath);
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        if (!empty($result['errors'])) {
            $io->warning('Lignes ignorées :');
            foreach ($result['errors'] as $error) {
                $io->text(" - $error");
            }
        }

        $io->success("{$result['imported']} produit(s) importé(s) avec succès.");

        return Command::SUCCESS;
    }
}
