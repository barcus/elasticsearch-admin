<?php

namespace App\Security\Voter;

use App\Model\ElasticsearchRepositoryModel;
use App\Security\Voter\AbstractAppVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ElasticsearchRepositoryVoter extends AbstractAppVoter
{
    protected function supports($attribute, $subject)
    {
        $attributes = $this->appRoleManager->getAttributesByModule('repository');

        return in_array($attribute, $attributes) && $subject instanceof ElasticsearchRepositoryModel;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        return $this->security->isGranted('ROLE_ADMIN', $user);
    }
}
