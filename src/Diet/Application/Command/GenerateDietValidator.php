<?php

declare(strict_types=1);

namespace App\Diet\Application\Command;

use App\Diet\Domain\Repository\OwnerRepositoryInterface;

class GenerateDietValidator
{
    private $messages = [];

    private $ownerRepository;

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    public function isValid(GenerateDiet $generateDietCommand): bool
    {
        if (!$this->ownerRepository->findOneByEmail($generateDietCommand->getEmail())) {
            $this->addError(
                sprintf('Owner with email %s does not exist.', $generateDietCommand->getEmail())
            );

            return false;
        }

        if (\DateTime::createFromFormat('Y-m-d', $generateDietCommand->getStartDate()) === false) {
            $this->addError(
                sprintf('Date %s has wrong format. Use Y-m-d instead.', $generateDietCommand->getStartDate())
            );

            return false;
        }

        return true;
    }

    public function getErrorMessage(): ?string
    {
        return !empty($this->messages)
            ? reset($this->messages)
            : null;
    }

    private function addError(string $message)
    {
        $this->messages[] = $message;
    }
}
