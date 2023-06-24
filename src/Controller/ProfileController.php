<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/profile")]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'profile')]
    public function index(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        return $this->render(
            'profile/index.html.twig',
            [
                'user' => $user
            ]
        );
    }

}