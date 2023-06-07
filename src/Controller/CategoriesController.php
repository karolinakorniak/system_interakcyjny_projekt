<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/categories")]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'category_index')]
    public function index(Request $request, CategoryRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE,
        );

        return $this->render(
            'categories/index.html.twig',
            ['pagination' => $pagination]
        );
    }
}