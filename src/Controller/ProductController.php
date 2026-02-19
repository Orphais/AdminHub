<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\Product\ProductFlowData;
use App\Form\Product\ProductFlowType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product.list')]
    public function list(ProductRepository $productRepository, Request $request): Response
    {
        $sortByPrice = $request->query->getBoolean('sortByPrice');

        $products = $sortByPrice
            ? $productRepository->findAllOrderedByPriceDesc()
            : $productRepository->findAll();

        return $this->render('pages/product/productList.html.twig', [
            'products' => $products,
            'sortByPrice' => $sortByPrice,
        ]);
    }

    #[Route('/product/new', name: 'product.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $flow = $this->createForm(ProductFlowType::class, new ProductFlowData())
            ->handleRequest($request);

        if ($flow->isSubmitted() && $flow->isValid() && $flow->isFinished()) {
            $data = $flow->getData();

            $product = new Product();
            $product->setType($data->type->type);
            $product->setName($data->details->name);
            $product->setDescription($data->details->description);
            $product->setPrice($data->details->price);

            if ($data->type->type === 'physical') {
                $product->setWeight($data->logistics->weight);
                $product->setWidth($data->logistics->width);
                $product->setHeight($data->logistics->height);
                $product->setDepth($data->logistics->depth);
                $product->setStock($data->logistics->stock);
            } else {
                $product->setLicenseKey($data->license->licenseKey);
                $product->setDownloadUrl($data->license->downloadUrl);
            }

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Produit créé !');
            return $this->redirectToRoute('product.list');
        }

        return $this->render('pages/product/new.html.twig', [
            'form' => $flow->getStepForm(),
        ]);
    }

    #[Route('/product/edit/{id}', name: 'product.edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a bien été modifié.');

            return $this->redirectToRoute('product.list');
        }

        return $this->render('pages/product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product.delete', methods: ['POST'])]
    public function delete(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a bien été supprimé.');
        }

        return $this->redirectToRoute('product.list');
    }
}
