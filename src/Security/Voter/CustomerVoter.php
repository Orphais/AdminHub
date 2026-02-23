<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class CustomerVoter extends Voter
{
    public const CUSTOMER_VIEW = 'CUSTOMER_VIEW';
    public const CUSTOMER_MANAGE = 'CUSTOMER_MANAGE';

    private const ALLOWED_ROLES = ['ROLE_ADMIN', 'ROLE_MANAGER'];

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::CUSTOMER_VIEW, self::CUSTOMER_MANAGE], true);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        foreach ($user->getRoles() as $role) {
            if (in_array($role, self::ALLOWED_ROLES, true)) {
                return true;
            }
        }

        return false;
    }
}
