<?php

namespace App\Controller; // App => scr

use App\Entity\Comment;
use App\Entity\Conference;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConferenceController extends AbstractController
{
    #[Route('/', name: 'home_page')] // -> la route, name -> le nom de la route à utiliser dans la vue (par ex)
    public function index(ConferenceRepository $conferenceRepository): Response
    {
         return $this->render('conference/index.html.twig', [
             'conferences' => $conferenceRepository->findAll(),
         ]);

    }

    #[Route('/conference/{id}', name: 'conference')]
    public function show(
        Conference $conference, 
        CommentRepository $commentRepository, 
        EntityManagerInterface $entityManager, 
        Request $request
        ): Response {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment -> setConference($conference);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this-> redirectToRoute('conference', ['id' => $conference->getId()]);
        }

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $commentRepository->findBy(['conference' => $conference], ['createdAt' => 'DESC']),
            'comment_form' => $form
        ]);
    }
}


