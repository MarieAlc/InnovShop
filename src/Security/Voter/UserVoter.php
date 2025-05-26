<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserVoter extends Voter
{
    public const EDIT = 'USER_EDIT';
    public const VIEW = 'USER_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {

        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();


        if (!$user instanceof UserInterface) {
            return false;
        }
        /** @var \App\Entity\User $targetUser  */
        $targetUser = $subject;
        switch ($attribute) {
            case self::EDIT:
            case self::VIEW:
                return $user === $targetUser || in_array('ROLE_ADMIN', $user->getRoles());


        }

        return false;
    }
}
