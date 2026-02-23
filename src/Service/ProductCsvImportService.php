<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductCsvImportService
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    /**
     * @return array{imported: int, errors: string[]}
     */
    public function import(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("Le fichier '$filePath' est introuvable.");
        }

        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            throw new \RuntimeException("Impossible d'ouvrir le fichier '$filePath'.");
        }

        $headers = fgetcsv($handle, 0, ';');

        if ($headers === false) {
            fclose($handle);
            throw new \RuntimeException('Le fichier CSV est vide.');
        }

        $headers = array_map('trim', $headers);
        $headers[0] = ltrim($headers[0], "\xEF\xBB\xBF");

        $requiredColumns = ['name', 'description', 'price'];
        $missing = array_diff($requiredColumns, $headers);

        if (!empty($missing)) {
            fclose($handle);
            throw new \InvalidArgumentException('Colonnes manquantes : ' . implode(', ', $missing));
        }

        $imported = 0;
        $errors = [];
        $line = 1;

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $line++;

            if (count($row) < count($requiredColumns)) {
                $errors[] = "Ligne $line : données insuffisantes.";
                continue;
            }

            $data = array_combine($headers, array_pad($row, count($headers), null));

            if (empty(trim((string) $data['name']))) {
                $errors[] = "Ligne $line : le nom est obligatoire.";
                continue;
            }

            if (!is_numeric($data['price'])) {
                $errors[] = "Ligne $line : prix invalide ({$data['price']}).";
                continue;
            }

            $product = new Product();
            $product->setName(trim($data['name']));
            $product->setDescription(trim((string) $data['description']) ?: null);
            $product->setPrice((float) $data['price']);
            $product->setType('physical');

            $this->entityManager->persist($product);
            $imported++;
        }

        fclose($handle);

        if ($imported > 0) {
            $this->entityManager->flush();
        }

        return ['imported' => $imported, 'errors' => $errors];
    }
}
