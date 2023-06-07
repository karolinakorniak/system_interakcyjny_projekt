<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/questions")]
class QuestionsController extends AbstractController
{
    #[Route('/', name: 'question_index')]
    public function index(Request $request, QuestionRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
        );

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    #[Route('/{slug}', name: 'single_question')]
    public function singleQuestion(string $slug, QuestionRepository $repository): Response
    {
        $question = $repository->findOneBy(['slug' => $slug]);

        return $this->render(
            'questions/single.html.twig',
            ['question' => $question]
        );
    }

    #[Route('/byCategory/{categorySlug}', name: "question_by_category")]
    public function byCategory(Request            $request,
                               QuestionRepository $questionRepository,
                               CategoryRepository $categoryRepository,
                               PaginatorInterface $paginator,
                               string             $categorySlug): Response
    {
        $pagination = $paginator->paginate(
            $questionRepository->queryByCategorySlug($categorySlug),
            $request->query->getInt('page', 1),
            QuestionRepository::PAGINATOR_ITEMS_PER_PAGE,
        );

        $category = $categoryRepository->findOneBy(["slug" => $categorySlug]);

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination, 'category' => $category]
        );

    }
}