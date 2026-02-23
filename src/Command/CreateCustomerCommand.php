<?php

namespace App\Command;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-customer',
    description: 'Crée un nouveau client en ligne de commande',
)]
class CreateCustomerCommand extends Command
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Création d\'un nouveau client');

        $firstName = $io->ask('Prénom', null, $this->validateName(...));
        $lastName = $io->ask('Nom', null, $this->validateName(...));
        $email = $io->ask('Email', null, $this->validateEmail(...));
        $phoneNumber = $io->ask('Téléphone (optionnel)') ?: null;
        $address = $io->ask('Adresse (optionnelle)') ?: null;

        $customer = new Customer();
        $customer->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPhoneNumber($phoneNumber)
            ->setAddress($address);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $io->success("Client \"{$firstName} {$lastName}\" créé avec succès (ID : {$customer->getId()}).");

        return Command::SUCCESS;
    }

    private function validateName(?string $value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            throw new \RuntimeException('Ce champ ne peut pas être vide.');
        }

        if (!preg_match('/^[\pL\s\-\']+$/u', $value)) {
            throw new \RuntimeException('Ce champ ne doit pas contenir de caractères spéciaux.');
        }

        return $value;
    }

    private function validateEmail(?string $value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            throw new \RuntimeException('L\'email ne peut pas être vide.');
        }

        if (!filter_var($value, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^@]+@[^@]+\.[^@]{2,}$/', $value)) {
            throw new \RuntimeException('Format d\'email invalide (attendu : xxx@xxx.xx).');
        }

        if ($this->customerRepository->findOneBy(['email' => $value]) !== null) {
            throw new \RuntimeException("L'adresse email \"{$value}\" est déjà utilisée par un autre client.");
        }

        return $value;
    }
}
