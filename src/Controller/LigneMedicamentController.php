<?php
// src/Controller/LigneMedicamentController.php
namespace App\Controller;

use App\Entity\LigneMedicament;
use App\Entity\Medicament;
use App\Form\LigneMedicamentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LigneMedicamentController extends AbstractController
{
    #[Route('/ligne_medicament', name: 'ligne_medicament_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $lignes = $entityManager->getRepository(LigneMedicament::class)->findAll();

        return $this->render('ligne_medicament/index.html.twig', [
            'lignes' => $lignes,
        ]);
    }

    #[Route('/ligne_medicament/new', name: 'ligne_medicament_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ligneMedicament = new LigneMedicament();
        $form = $this->createForm(LigneMedicamentType::class, $ligneMedicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicament = $ligneMedicament->getMedicament();
            $ligneMedicament->setQuantite($medicament->getQteStock());
            $entityManager->persist($ligneMedicament);
            $entityManager->flush();

            return $this->redirectToRoute('ligne_medicament_index');
        }

        return $this->render('ligne_medicament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}