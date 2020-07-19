<?php

namespace App\Security\Voter;

use App\Model\ElasticsearchSnapshotModel;
use App\Security\Voter\AbstractAppVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ElasticsearchSnapshotVoter extends AbstractAppVoter
{
    protected function supports($attribute, $subject)
    {
        $attributes = $this->appRoleManager->getAttributesByModule('snapshot');

        return in_array($attribute, $attributes) && $subject instanceof ElasticsearchSnapshotModel;
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
