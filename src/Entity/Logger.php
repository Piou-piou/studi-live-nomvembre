<?php

namespace App\Entity;

use App\Repository\LoggerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoggerRepository::class)]
class Logger
{
    public const CREATED = 'CREATED';
    public const UPDATED = 'UPDATED';
    public const DELETED = 'DELETED';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $entity_name;

    #[ORM\Column]
    private int $entity_id;

    #[ORM\Column(length: 255)]
    private string $updated_type;

    #[ORM\Column]
    private array $previous_data = [];

    #[ORM\Column]
    private array $current_data = [];

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $created_by;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $updated_by;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityName(): string
    {
        return $this->entity_name;
    }

    public function setEntityName(string $entity_name): self
    {
        $this->entity_name = $entity_name;
        return $this;
    }

    public function getEntityId(): int
    {
        return $this->entity_id;
    }

    public function setEntityId(int $entity_id): self
    {
        $this->entity_id = $entity_id;
        return $this;
    }

    public function getUpdatedType(): string
    {
        return $this->updated_type;
    }

    public function setUpdatedType(string $updated_type): self
    {
        $this->updated_type = $updated_type;
        return $this;
    }

    public function getPreviousData(): array
    {
        return $this->previous_data;
    }

    public function setPreviousData(array $previous_data): self
    {
        $this->previous_data = $previous_data;
        return $this;
    }

    public function getCurrentData(): array
    {
        return $this->current_data;
    }

    public function setCurrentData(array $current_data): self
    {
        $this->current_data = $current_data;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;
        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $updated_by): self
    {
        $this->updated_by = $updated_by;
        return $this;
    }
}
