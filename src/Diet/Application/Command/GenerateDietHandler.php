<?php

declare(strict_types=1);

namespace App\Diet\Application\Command;

use App\Diet\Application\Exception\CommandNotValidException;
use App\Diet\Domain\Model\Day;
use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\Period;
use App\Diet\Domain\Repository\DietPlanRepositoryInterface;
use App\Diet\Domain\Repository\MealRepositoryInterface;
use App\Diet\Domain\Repository\OwnerRepositoryInterface;
use App\Diet\Domain\Repository\PeriodRepositoryInterface;
use App\Diet\Domain\Service\CalorieCalculator;

class GenerateDietHandler
{
    private $generateDietValidator;

    private $calorieCalculator;

    private $periodRepository;

    private $ownerRepository;

    private $dietPlanRepository;

    private $mealRepository;

    public function __construct(
        GenerateDietValidator $generateDietValidator,
        CalorieCalculator $calorieCalculator,
        PeriodRepositoryInterface $periodRepository,
        OwnerRepositoryInterface $ownerRepository,
        DietPlanRepositoryInterface $dietPlanRepository,
        MealRepositoryInterface $mealRepository
    ) {
        $this->generateDietValidator = $generateDietValidator;
        $this->calorieCalculator = $calorieCalculator;
        $this->periodRepository = $periodRepository;
        $this->ownerRepository = $ownerRepository;
        $this->dietPlanRepository = $dietPlanRepository;
        $this->mealRepository = $mealRepository;
    }

    public function handle(GenerateDiet $generateDietCommand): void
    {
        if (!$this->generateDietValidator->isValid($generateDietCommand)) {
            throw new CommandNotValidException($this->generateDietValidator->getErrorMessage());
        }

        $owner = $this->ownerRepository->findOneByEmail($generateDietCommand->getEmail());
        $dietPlan = $this->dietPlanRepository->findForOwner($owner);
        $period = new Period($dietPlan);

        for ($dayNumber = 0; $dayNumber < $dietPlan->getDaysQuantity(); $dayNumber++) {
            $date = new \DateTime($generateDietCommand->getStartDate());
            $date->modify(sprintf('+%d days', $dayNumber));
            $day = new Day($date);

            for ($mealNumber = 1; $mealNumber <= $dietPlan->getMealsQuantity(); $mealNumber++) {
                $mealCalorie = $this->calorieCalculator->calculatePermissibleMealCalories(
                    $owner,
                    $dietPlan->getType(),
                    $mealNumber
                );

                $excludedMealIds = [];
                $isWithMeat = $day->getName() !== 'Fri' || $day->isMeatFriday($dietPlan->getOption()->hasMeatFriday());
                if (!$isWithMeat) {
                    $meatMeals = $this->mealRepository->findAllInCalorieRangeWithMeat($mealCalorie);

                    $excludedMealIds = array_map(function (Meal $meatMeal) {
                        return $meatMeal->getId();
                    }, $meatMeals);
                }

                $meal = $this->mealRepository->findRandomInCalorieRange($mealCalorie, $excludedMealIds);
                $day->addMeal($meal);
            }

            if ($dayNumber < ($dietPlan->getOption()->getRepetitiveDaysQuantity() * 2 )) {
                $dayClone = clone $day;
                $dateClone = \DateTimeImmutable::createFromMutable($dayClone->getDate());
                $dayClone->changeDate($dateClone->modify('+1 days'));

                $period->addDay($dayClone);

                $dayNumber++;
            }

            $period->addDay($day);
        }

        $this->periodRepository->save($period);
    }
}
