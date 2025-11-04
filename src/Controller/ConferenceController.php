<?php

namespace App\Controller; // App => scr

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConferenceController extends AbstractController
{
    #[Route('/', name: 'home_page')] // -> la route, name -> le nom de la route à utiliser dans la vue (par ex)
    public function index(): Response
    {
        // return $this->render('conference/index.html.twig', [
        //     'controller_name' => 'ConferenceController',
        // ]);

        return new Response(<<<EOF
            <html>
                <body>
                   <img src="/images/under-construction.gif" />
                </body>
            </html>
            EOF
        );
    }
}
