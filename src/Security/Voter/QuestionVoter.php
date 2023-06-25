<?php

namespace App\Security\Voter;

use App\Entity\Question;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class QuestionVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Question;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    /**
     * Checks if user can edit question.
     *
     * @param Question $question Question entity
     * @param User $user User
     *
     * @return bool Result
     */
    private function canEdit(Question $question, User $user): bool
    {
        return $question->getAuthor() === $user;
    }

    /**
     * Checks if user can view task.
     *
     * @param Question $question Question entity
     * @param User $user User
     *
     * @return bool Result
     */
    private function canView(Question $question, User $user): bool
    {
        return $question->getAuthor() === $user;
    }

    /**
     * Checks if user can delete task.
     *
     * @param Question $question Question entity
     * @param User $user User
     *
     * @return bool Result
     */
    private function canDelete(Question $question, User $user): bool
    {
        return $question->getAuthor() === $user;
    }
}
