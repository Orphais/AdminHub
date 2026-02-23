<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductCsvExportService
{
    /**
     * @param Product[] $products
     */
    public function export(array $products): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($products) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['name', 'description', 'price', 'type', 'weight', 'width', 'height', 'depth', 'stock', 'licenseKey', 'downloadUrl'], ';');

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->getName(),
                    $product->getDescription(),
                    number_format($product->getPrice(), 2, '.', ''),
                    $product->getType(),
                    $product->getWeight(),
                    $product->getWidth(),
                    $product->getHeight(),
                    $product->getDepth(),
                    $product->getStock(),
                    $product->getLicenseKey(),
                    $product->getDownloadUrl(),
                ], ';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="products.csv"');

        return $response;
    }
}
