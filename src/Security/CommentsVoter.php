<?php

namespace App\Security;

use App\Entity\Comments;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommentsVoter extends Voter
{
    const EDIT="EDIT_COMMENT";

    protected function supports($attribute, $subject)
    {
        return $attribute === self::EDIT && $subject instanceof Comments;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // the user must be logged in; if not, deny permission
        if (!$user instanceof Users || !$subject instanceof Comments) {
            return false;
        }
        
        return $subject->getUsers()->getId() === $user->getId();
    }
}