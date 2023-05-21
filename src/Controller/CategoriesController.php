<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController
{
    #[Route('/categories')]
    public function index(): Response
    {
        return new Response(
            '<html><body>Tutaj beda kategorie</body></html>'
        );
    }
}