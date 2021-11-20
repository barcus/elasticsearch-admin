<?php

namespace App\Model;

use App\Model\AbstractAppModel;
use App\Traits\ElasticsearchRoleUserModelTrait;

class ElasticsearchUserModel extends AbstractAppModel
{
    use ElasticsearchRoleUserModelTrait;

    private $name;

    private $enabled;

    private $email;

    private $fullName;

    private $changePassword;

    private $password;

    private $roles;

    public function __construct()
    {
        $this->enabled = true;
        $this->changePassword = false;
        $this->roles = [];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getChangePassword(): ?bool
    {
        return $this->changePassword;
    }

    public function setChangePassword(?bool $changePassword): self
    {
        $this->changePassword = $changePassword;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getRoles(): ?array
    {
        return array_values($this->roles);
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function convert(?array $user): self
    {
        $this->setName($user['username']);
        $this->setFullName($user['full_name']);
        $this->setEmail($user['email']);
        $this->setRoles($user['roles']);
        $this->setEnabled($user['enabled']);
        if (true === isset($user['metadata']) && 0 < count($user['metadata'])) {
            $this->setMetadata($user['metadata']);
            $this->setMetadataJson(json_encode($user['metadata'], JSON_PRETTY_PRINT));
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
