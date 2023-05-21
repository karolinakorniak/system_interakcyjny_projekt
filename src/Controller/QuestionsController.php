<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
class QuestionsController
{
    public function index(): Response
    {

        return new Response(
            '<html><body>Tutaj beda pytania</body></html>'
        );
    }
}