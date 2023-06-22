<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route("/categories")]
class CategoriesController extends AbstractController
{
    /**
     * Category Service
     */
    private CategoryServiceInterface $categoryService;

    /**
     * TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(CategoryServiceInterface $categoryService, TranslatorInterface $translator)
    {
        $this->categoryService = $categoryService;
        $this->translator = $translator;
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

    #[Route('/create', name: 'add_category')]
    public function create(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setAuthor($this->getUser());
            $this->categoryService->saveCategory($category);

            $this->addFlash(
                'success',
                $this->translator->trans('category.created')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'categories/addCategory.html.twig',
            ['form' => $form->createView()]
        );

    }
}