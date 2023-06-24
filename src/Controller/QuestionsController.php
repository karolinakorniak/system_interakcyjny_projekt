<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Form\Type\AnswerType;
use App\Form\Type\QuestionType;
use App\Service\QuestionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route("/questions")]
class QuestionsController extends AbstractController
{
    /**
     * Question Service
     */
    private QuestionServiceInterface $questionService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * @param QuestionServiceInterface $questionService
     */
    public function __construct(QuestionServiceInterface $questionService, TranslatorInterface $translator)
    {
        $this->questionService = $questionService;
        $this->translator = $translator;
    }


    #[Route('/', name: 'question_index')]
    public function index(Request $request): Response
    {
        $pagination = $this->questionService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Create a question.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'add_question',
        methods: 'GET|POST',
    )]
    public function addQuestion(Request $request): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setAuthor($this->getUser());
            $this->questionService->saveQuestion($question);

            $this->addFlash(
                'success',
                $this->translator->trans('questions.created')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'questions/addQuestion.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit a question.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{slug}/edit',
        name: 'edit_question',
        methods: 'GET|PUT',
    )]
    public function editQuestion(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question, [
            'method' => 'PUT',
            'action' => $this->generateUrl('edit_question', ['slug' => $question->getSlug()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->questionService->saveQuestion($question);

            $this->addFlash(
                'success',
                $this->translator->trans('questions.edited')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'questions/editQuestion.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Question $question Question entity
     *
     * @return Response HTTP response
     */
    #[Route('/{slug}/delete',
        name: 'delete_question',
        methods: 'GET|DELETE')]
    public function delete(Request $request, Question $question): Response
    {
        $form = $this->createForm(
            FormType::class,
            $question,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('delete_question', ['slug' => $question->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->questionService->deleteQuestion($question);

            $this->addFlash(
                'success',
                $this->translator->trans('questions.deleted')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'questions/delete.html.twig',
            [
                'form' => $form->createView(),
                'question' => $question
            ]
        );
    }

    #[Route('/{slug}', name: 'single_question')]
    public function singleQuestion(Question $question): Response
    {
        return $this->render(
            'questions/single.html.twig',
            ['question' => $question]
        );
    }

    #[Route('/byCategory/{slug}', name: "question_by_category")]
    public function byCategory(Request  $request,
                               string   $slug,
                               Category $category): Response
    {
        $pagination = $this->questionService->getPaginatedListByCategory(
            $request->query->getInt('page', 1),
            $slug
        );

        return $this->render(
            'questions/index.html.twig',
            ['pagination' => $pagination, 'category' => $category]
        );
    }

    /**
     * Add answer to a question.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{slug}/addAnswer',
        name: 'add_answer',
        methods: 'GET|POST',
    )]
    public function addAnswer(Request $request, Question $question, $slug): Response
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->questionService->saveAnswer($answer, $question);

            $this->addFlash(
                'success',
                $this->translator->trans('answer.created')
            );

            return $this->redirectToRoute('single_question', ['slug' => $slug]);
        }

        return $this->render(
            'questions/addAnswer.html.twig',
            ['form' => $form->createView(), 'question' => $question]
        );
    }

    /**
     * Mark answer as deleted.
     *
     * @param Request $request HTTP Request
     * @param Answer $answer Answer entity
     * @return Response HTTP Response
     */
    #[Route('/answer/{id}',
        name: "delete_answer",
        methods: 'DELETE|GET'
    )]
    public function markAnswerAsDeleted(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(
            FormType::class,
            $answer,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('delete_answer', ['id' => $answer->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->questionService->markAnswerAsDeleted($answer);

            $this->addFlash(
                'success',
                $this->translator->trans('answers.deleted')
            );

            return $this->redirectToRoute('single_question', ['slug' => $answer->getQuestion()->getSlug()]);
        }

        return $this->render(
            'questions/deleteAnswer.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer
            ]
        );
    }
}