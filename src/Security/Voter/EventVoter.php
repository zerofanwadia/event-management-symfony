<?php

namespace App\Security\Voter;

use App\Entity\Event;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;


class EventVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const ARCHIVE = 'ARCHIVE';
    public const RESERVE = 'RESERVE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::ARCHIVE, self::RESERVE])
            && $subject instanceof Event;
    }

    /**
     * @param string $attribute
     * @param Event $subject
     * @param TokenInterface $token
     * @return boolean
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $user == $subject->getUser() && !$subject->isArchived();
            case self::ARCHIVE:
                return $user == $subject->getUser() && !$subject->isArchived();
            case self::RESERVE:
                return $subject->canReserve($user);
        }

        return false;
    }
}
