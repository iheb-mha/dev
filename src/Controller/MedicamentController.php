<?php 
// src/Controller/MedicamentController.php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MedicamentController extends AbstractController
{
    #[Route('/medicament/new', name: 'medicament_new')]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
               $filename = pathinfo($photoFile->getClientOriginalName(),PATHINFO_FILENAME);
               $originalname = $slugger->slug($filename);
               $newFilename = $originalname.'-'.uniqid().'-'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                }catch(FileException $e){
                //... exception
                }
            }
            $medicament->setPhoto($newFilename);
            $entityManager->persist($medicament);
            $entityManager->flush();

            return $this->redirectToRoute('medicament_index');
        }

        return $this->render('medicament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    #[Route('/medicament/success', name: 'medicament_success')]
//    public function success(): Response
//    {
//        return new Response('<html><body>Medicament added successfully!</body></html>');
//    }

    #[Route('/medicament', name: 'medicament_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Fetch all Medicament entities
        $medicaments = $entityManager->getRepository(Medicament::class)->findAll();

        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicaments,
        ]);
    }

    #[Route('/medicament/{id}/edit', name: 'medicament_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medicament $medicament, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                // Read the binary data from the uploaded file
                $photoData = file_get_contents($photoFile->getPathname());

                // Update the 'photo' property to store the binary data
                $medicament->setPhoto($photoData);
            }

            $entityManager->flush();

            return $this->redirectToRoute('medicament_index');
        }

        return $this->render('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/medicament/{id}', name: 'medicament_delete', methods: ['POST'])]
    public function delete(Request $request, Medicament $medicament, EntityManagerInterface $entityManager): Response
    {

        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            $entityManager->remove($medicament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('medicament_index');
    }
}