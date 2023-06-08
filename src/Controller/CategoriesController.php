<?php

namespace App\Controller;

use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/categories")]
class CategoriesController extends AbstractController
{
    /**
     * Category Service
     */
    private CategoryServiceInterface $categoryService;

    /**
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    #[Route('/', name: 'category_index')]
    public function index(Request $request): Response
    {
        $pagination = $this->categoryService->getPaginatedList(
            $request->query->getInt('page', 1),
        );

        return $this->render(
            'categories/index.html.twig',
            ['pagination' => $pagination]
        );
    }
}