<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\Session1Type;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/symfony/console/make/crud/stagiaire')]
class SymfonyConsoleMakeCrudStagiaireController extends AbstractController
{
    #[Route('/', name: 'app_symfony_console_make_crud_stagiaire_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('symfony_console_make_crud_stagiaire/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_symfony_console_make_crud_stagiaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $form = $this->createForm(Session1Type::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_symfony_console_make_crud_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('symfony_console_make_crud_stagiaire/new.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_symfony_console_make_crud_stagiaire_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('symfony_console_make_crud_stagiaire/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_symfony_console_make_crud_stagiaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Session1Type::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_symfony_console_make_crud_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('symfony_console_make_crud_stagiaire/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_symfony_console_make_crud_stagiaire_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_symfony_console_make_crud_stagiaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
