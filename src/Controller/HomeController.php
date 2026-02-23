<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        ProductRepository $productRepository,
        CustomerRepository $customerRepository,
        UserRepository $userRepository,
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('security.login');
        }

        return $this->render('pages/home/index.html.twig', [
            'productCount' => $productRepository->count(),
            'customerCount' => $customerRepository->count(),
            'userCount' => $userRepository->count(),
            'recentCustomers' => $customerRepository->findBy([], ['createdAt' => 'DESC'], 5),
            'recentProducts' => $productRepository->findBy([], ['id' => 'DESC'], 5),
        ]);
    }
}
