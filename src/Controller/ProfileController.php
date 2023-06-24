<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route("/profile")]
class ProfileController extends AbstractController
{
    /**
     * UserService
     */
    private UserServiceInterface $userService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param TranslatorInterface $translator
     * @param UserServiceInterface $userService
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher,
                                TranslatorInterface $translator,
                                UserServiceInterface $userService)
    {
        $this->passwordHasher = $passwordHasher;
        $this->translator = $translator;
        $this->userService = $userService;
    }


    /**
     * Index action
     *
     * @return Response HTTP Response
     */
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

    #[Route('/change_password', name: "change_password", methods: "PUT|GET")]
    public function changePassword(Request $request): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, null, [
            'method' => 'PUT',
            'action' => $this->generateUrl('change_password')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (!$this->passwordHasher->isPasswordValid($user, $data["oldPassword"]))
            {
                $this->addFlash("error", $this->translator->trans('profile.incorrectPassword'));
                return $this->render(
                    'profile/changePassword.html.twig',
                    ['form' => $form->createView()]
                );
            }

            if ($data["newPassword"] !== $data["confirmPassword"])
            {
                $this->addFlash("error", $this->translator->trans('profile.passwordMismatch'));
                return $this->render(
                    'profile/changePassword.html.twig',
                    ['form' => $form->createView()]
                );
            }

            $this->userService->updatePassword($user, $data["newPassword"]);

            $this->addFlash(
                'success',
                $this->translator->trans('profile.passwordUpdated')
            );

            return $this->redirectToRoute('profile');
        }

        return $this->render(
            'profile/changePassword.html.twig',
            ['form' => $form->createView()]
        );
    }
}