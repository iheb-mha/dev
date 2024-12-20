<?php

namespace App\Controller;

use App\Entity\LigneBonDeCommande;
use App\Form\LigneBonDeCommandeType;
use App\Repository\LigneBonDeCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ligne_bon_de_commande')]
final class LigneBonDeCommandeController extends AbstractController
{
    #[Route('/', name: 'app_ligne_bon_de_commande_index', methods: ['GET'])]
    public function index(LigneBonDeCommandeRepository $ligneBonDeCommandeRepository): Response
    {
        return $this->render('ligne_bon_de_commande/index.html.twig', [
            'ligne_bon_de_commandes' => $ligneBonDeCommandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ligne_bon_de_commande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneBonDeCommande = new LigneBonDeCommande();
        $form = $this->createForm(LigneBonDeCommandeType::class, $ligneBonDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ligneBonDeCommande);
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_bon_de_commande/new.html.twig', [
            'ligne_bon_de_commande' => $ligneBonDeCommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ligne_bon_de_commande_show', methods: ['GET'])]
    public function show(LigneBonDeCommande $ligneBonDeCommande): Response
    {
        return $this->render('ligne_bon_de_commande/show.html.twig', [
            'ligne_bon_de_commande' => $ligneBonDeCommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ligne_bon_de_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LigneBonDeCommande $ligneBonDeCommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneBonDeCommandeType::class, $ligneBonDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ligne_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_bon_de_commande/edit.html.twig', [
            'ligne_bon_de_commande' => $ligneBonDeCommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_ligne_bon_de_commande_delete', methods: ['POST'])]
    public function delete(Request $request, LigneBonDeCommande $ligneBonDeCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ligneBonDeCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ligneBonDeCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ligne_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
