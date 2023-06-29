<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CategoriesController.
 */
#[Route('/categories')]
class CategoriesController extends AbstractController
{
    /**
     * Category Service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * TranslatorInterface.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category Service
     * @param TranslatorInterface      $translator      Translator
     */
    public function __construct(CategoryServiceInterface $categoryService, TranslatorInterface $translator)
    {
        $this->categoryService = $categoryService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP Response
     */
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

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{slug}/edit',
        name: 'edit_category',
        methods: 'GET|PUT',
    )]
    #[IsGranted('EDIT', subject: 'category')]
    public function editQuestion(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'method' => 'PUT',
            'action' => $this->generateUrl('edit_category', ['slug' => $category->getSlug()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->saveCategory($category);

            $this->addFlash(
                'success',
                $this->translator->trans('categories.edited')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'categories/edit.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Category $category Category entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{slug}/delete',
        name: 'delete_category',
        methods: 'GET|DELETE'
    )]
    #[IsGranted('DELETE', subject: 'category')]
    public function delete(Request $request, Category $category): Response
    {
        $form = $this->createForm(
            FormType::class,
            $category,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('delete_category', ['slug' => $category->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->deleteCategory($category);

            $this->addFlash(
                'success',
                $this->translator->trans('category.deleted')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'categories/delete.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category,
            ]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP Response
     */
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
            'categories/add.html.twig',
            ['form' => $form->createView()]
        );
    }
}
