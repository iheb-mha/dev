<?php

namespace App\Controller;

use App\Entity\BonDeCommande;
use App\Form\BonDeCommandeType;
use App\Repository\BonDeCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bon_de_commande')]
final class BonDeCommandeController extends AbstractController
{
    #[Route(name: 'app_bon_de_commande_index', methods: ['GET'])]
    public function index(BonDeCommandeRepository $bonDeCommandeRepository): Response
    {
        return $this->render('bon_de_commande/index.html.twig', [
            'bon_de_commandes' => $bonDeCommandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bon_de_commande_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bonDeCommande = new BonDeCommande();
        $form = $this->createForm(BonDeCommandeType::class, $bonDeCommande);
        $user = $this->getUser();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($bonDeCommande->getLigneCommandes() as $ligneCommande) {
                $ligneCommande->setBonDeCommande($bonDeCommande);
                $ligneCommande->setUserId($user);
            }

            $entityManager->persist($bonDeCommande);
            $entityManager->flush();

            return $this->redirectToRoute('app_bon_de_commande_index');
        }

        return $this->render('bon_de_commande/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_bon_de_commande_show', methods: ['GET'])]
    public function show(BonDeCommande $bonDeCommande): Response
    {
        return $this->render('bon_de_commande/show.html.twig', [
            'bon_de_commande' => $bonDeCommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bon_de_commande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BonDeCommande $bonDeCommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BonDeCommandeType::class, $bonDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bon_de_commande/edit.html.twig', [
            'bon_de_commande' => $bonDeCommande,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_bon_de_commande_delete', methods: ['POST'])]
    public function delete(Request $request, BonDeCommande $bonDeCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bonDeCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bonDeCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bon_de_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
