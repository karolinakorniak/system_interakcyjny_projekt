<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController
{
    #[Route('/questions')]
    public function index(): Response
    {
        return new Response(
            '<html><body>Tutaj beda pytania</body></html>'
        );
    }
}