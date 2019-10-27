<?php

declare(strict_types=1);

namespace App\Diet\Application\Command;

use App\Diet\Application\Exception\CommandNotValidException;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Model\Period;
use App\Diet\Infrastructure\Repository\OwnerRepository;
use App\Diet\Infrastructure\Repository\PeriodRepository;

class GenerateDietHandler
{
    private $commandValidator;

    private $ownerRepository;

    private $periodRepository;

    public function __construct(
        GenerateDietValidator $commandValidator,
        OwnerRepository $ownerRepository,
        PeriodRepository $periodRepository
    ) {
        $this->commandValidator = $commandValidator;
        $this->ownerRepository = $ownerRepository;
        $this->periodRepository = $periodRepository;
    }

    public function handle(GenerateDiet $generateDietCommand)
    {
        if (!$this->commandValidator->isValid($generateDietCommand)) {
            throw new CommandNotValidException($this->commandValidator->getErrorMessage());
        }

        $owner = $this->ownerRepository->findOneByEmail($generateDietCommand->getEmail());
    }
}
