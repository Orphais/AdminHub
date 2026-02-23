<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CustomerController extends AbstractController
{
    #[Route('/customers', name: 'customer.list')]
    public function list(CustomerRepository $customerRepository): Response
    {
        $this->denyAccessUnlessGranted('CUSTOMER_VIEW');

        return $this->render('pages/customer/customerList.html.twig', [
            'customers' => $customerRepository->findAll(),
        ]);
    }

    #[Route('/customer/new', name: 'customer.new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('CUSTOMER_MANAGE');

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($customer);
            $entityManager->flush();

            $this->addFlash('success', 'Le client a bien été créé.');

            return $this->redirectToRoute('customer.list');
        }

        return $this->render('pages/customer/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/customer/edit/{id}', name: 'customer.edit')]
    public function edit(Customer $customer, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('CUSTOMER_MANAGE');

        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le client a bien été modifié.');

            return $this->redirectToRoute('customer.list');
        }

        return $this->render('pages/customer/edit.html.twig', [
            'form' => $form->createView(),
            'customer' => $customer,
        ]);
    }
}
