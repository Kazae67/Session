<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\Session2Type;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\StagiaireRepository;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $form = $this->createForm(Session2Type::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Session2Type::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/non-inscrits', name: 'app_session_non_inscrits', methods: ['GET'])]
    public function showNonInscrits(Session $session, SessionRepository $sessionRepository): Response
    {
        $nonInscrits = $sessionRepository->findNonInscrits($session->getId());

        return $this->render('session/non_inscrits.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
        ]);
    }

    #[Route('/{id}/inscrits', name: 'app_session_inscrits', methods: ['GET'])]
    public function showInscrits(Session $session): Response
    {
        $inscrits = $session->getStagiaires();

        return $this->render('session/inscrits.html.twig', [
            'session' => $session,
            'inscrits' => $inscrits,
        ]);
    }

    #[Route('/{sessionId}/deprogrammer/{stagiaireId}', name: 'app_session_deprogrammer', methods: ['POST'])]
    public function deprogrammerStagiaire(int $sessionId, int $stagiaireId, EntityManagerInterface $entityManager): Response
    {
        $session = $entityManager->getRepository(Session::class)->find($sessionId);
        $stagiaire = $entityManager->getRepository(Stagiaire::class)->find($stagiaireId);

        if ($session && $stagiaire) {
            $session->removeStagiaire($stagiaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_inscrits', ['id' => $sessionId]);
    }

    #[Route('/{id}/inscrire', name: 'app_session_inscrire', methods: ['GET', 'POST'])]
    public function inscrireStagiaire(Request $request, Session $session, EntityManagerInterface $entityManager, SessionRepository $sessionRepository): Response
    {
        $nonInscrits = $sessionRepository->findNonInscrits($session->getId());
        $form = $this->createFormBuilder()
            ->add('stagiaire', EntityType::class, [
                'class' => Stagiaire::class,
                'choices' => $nonInscrits,
                'choice_label' => function(Stagiaire $stagiaire) {
                    return $stagiaire->getFirstName() . ' ' . $stagiaire->getLastName();
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscrire'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire = $form->get('stagiaire')->getData();
            $session->addStagiaire($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_inscrits', ['id' => $session->getId()]);
        }

        return $this->render('session/inscrire.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /*
        #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session, StagiaireRepository $stagiaireRepository): Response
    {
    // Récupérer tous les stagiaires non inscrits à cette session
    $allStagiaires = $stagiaireRepository->findAll();
    $inscrits = $session->getStagiaires()->toArray();
    $nonInscrits = array_diff($allStagiaires, $inscrits);

    return $this->render('session/show.html.twig', [
        'session' => $session,
        'nonInscrits' => $nonInscrits,
    ]);
}
    */


    /*
        #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session, StagiaireRepository $stagiaireRepository): Response
    {
        $allStagiaires = $stagiaireRepository->findAll();
        $stagiairesInSession = $session->getStagiaires();

        $stagiairesNotInSession = array_filter($allStagiaires, function ($stagiaire) use ($stagiairesInSession) {
            return !in_array($stagiaire, $stagiairesInSession->toArray());
        });

        return $this->render('session/show.html.twig', [
            'session' => $session,
            'stagiairesNotInSession' => $stagiairesNotInSession,
        ]);
    }
    */
}
