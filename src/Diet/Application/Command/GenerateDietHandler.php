<?php

declare(strict_types=1);

namespace App\Diet\Application\Command;

use App\Diet\Application\Exception\CommandNotValidException;
use App\Diet\Domain\Model\Day;
use App\Diet\Domain\Model\Period;
use App\Diet\Domain\Service\CalorieCalculator;
use App\Diet\Infrastructure\Repository\DietPlanRepository;
use App\Diet\Infrastructure\Repository\MealRepository;
use App\Diet\Infrastructure\Repository\OwnerRepository;
use App\Diet\Infrastructure\Repository\PeriodRepository;

class GenerateDietHandler
{
    private $commandValidator;

    private $calorieCalculator;

    private $ownerRepository;

    private $periodRepository;

    private $dietPlanRepository;

    private $mealRepository;

    public function __construct(
        GenerateDietValidator $commandValidator,
        CalorieCalculator $calorieCalculator,
        OwnerRepository $ownerRepository,
        PeriodRepository $periodRepository,
        DietPlanRepository $dietPlanRepository,
        MealRepository $mealRepository
    ) {
        $this->commandValidator = $commandValidator;
        $this->calorieCalculator = $calorieCalculator;
        $this->ownerRepository = $ownerRepository;
        $this->periodRepository = $periodRepository;
        $this->dietPlanRepository = $dietPlanRepository;
        $this->mealRepository = $mealRepository;
    }

    public function handle(GenerateDiet $generateDietCommand)
    {
        if (!$this->commandValidator->isValid($generateDietCommand)) {
            throw new CommandNotValidException($this->commandValidator->getErrorMessage());
        }

        $owner = $this->ownerRepository->findOneByEmail($generateDietCommand->getEmail());
        $dietPlan = $this->dietPlanRepository->findForOwner($owner);

        $period = new Period($dietPlan);

        for ($dayNumber = 0; $dayNumber < $dietPlan->getDaysQuantity(); $dayNumber++) {
            $date = (new \DateTime($generateDietCommand->getStartDate()))->modify('+' . $dayNumber . ' days');
            $day = new Day($date->format('D'), $date);

            for ($mealNumber = 1; $mealNumber <= $dietPlan->getType()->getMealsQuantity(); $mealNumber++) {
                $mealCalorie = $this->calorieCalculator
                    ->calculatePermissibleMealCalories($owner, $dietPlan->getType(), $mealNumber);
                $meal = $this->mealRepository->findRandomInCalorieRange($mealCalorie);
                $day->addMeal($meal);
            }

            $period->addDay($day);
        }

        $this->periodRepository->save($period);
    }
}
