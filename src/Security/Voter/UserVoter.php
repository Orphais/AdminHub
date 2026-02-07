<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserVoter extends Voter
{

    public const ADMIN_VIEW = 'ADMIN_VIEW';
    public const USER_VIEW = 'USER_VIEW';


    protected function supports(string $attribute, mixed $subject): bool
    {
        if ($attribute === self::ADMIN_VIEW) {
            return true;
        } else {
            return false;
        }
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        foreach ($user->getRoles() as $role) {
            if ($role === 'ROLE_ADMIN') {
                return true;
            }
        }

        return false;
    }
}
