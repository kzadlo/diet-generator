<?php

declare(strict_types=1);

namespace App\Diet\Tests\Application\Command;

use App\Diet\Application\Command\GenerateDiet;
use App\Diet\Application\Command\GenerateDietHandler;
use App\Diet\Application\Command\GenerateDietValidator;
use App\Diet\Application\Exception\CommandNotValidException;
use App\Diet\Domain\Model\DietOption;
use App\Diet\Domain\Model\DietPlan;
use App\Diet\Domain\Model\DietType;
use App\Diet\Domain\Model\Meal;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Model\Period;
use App\Diet\Domain\Repository\DietPlanRepositoryInterface;
use App\Diet\Domain\Repository\MealRepositoryInterface;
use App\Diet\Domain\Repository\OwnerRepositoryInterface;
use App\Diet\Domain\Repository\PeriodRepositoryInterface;
use App\Diet\Domain\Service\CalorieCalculator;
use App\Diet\Domain\ValueObject\Calorie;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class GenerateDietHandlerTest extends TestCase
{
    private $generateDietHandler;

    private $generateDietValidator;

    private $calorieCalculator;

    private $periodRepository;

    private $ownerRepository;

    private $dietPlanRepository;

    private $mealRepository;

    protected function setUp(): void
    {
        $this->generateDietValidator = $this->prophesize(GenerateDietValidator::class);
        $this->calorieCalculator = $this->prophesize(CalorieCalculator::class);
        $this->periodRepository = $this->prophesize(PeriodRepositoryInterface::class);
        $this->ownerRepository = $this->prophesize(OwnerRepositoryInterface::class);
        $this->dietPlanRepository = $this->prophesize(DietPlanRepositoryInterface::class);
        $this->mealRepository = $this->prophesize(MealRepositoryInterface::class);

        $this->generateDietHandler = new GenerateDietHandler(
            $this->generateDietValidator->reveal(),
            $this->calorieCalculator->reveal(),
            $this->periodRepository->reveal(),
            $this->ownerRepository->reveal(),
            $this->dietPlanRepository->reveal(),
            $this->mealRepository->reveal()
        );
    }

    public function testIsGenerateDietCommandValidated(): void
    {
        $generateDietCommand = new GenerateDiet('non-existent-owner@email.pl', '2019-12-12');

        $this->generateDietValidator
            ->isValid($generateDietCommand)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->generateDietValidator
            ->getErrorMessage()
            ->shouldBeCalled();

        $this->expectException(CommandNotValidException::class);

        $this->generateDietHandler->handle($generateDietCommand);
    }

    public function testIsGenerateDietCommand(): void
    {
        $generateDietCommand = new GenerateDiet('existent-owner@email.pl', '2019-12-12');

        $owner = $this->prophesize(Owner::class);
        $meal = $this->prophesize(Meal::class);
        $dietType = $this->prophesize(DietType::class);
        $dietOption = $this->prophesize(DietOption::class);
        $dietPlan = $this->prophesize(DietPlan::class);

        $dietOption
            ->hasMeatFriday()
            ->willReturn(false);

        $dietPlan
            ->getDaysQuantity()
            ->willReturn(DietOption::STANDARD_QUANTITY_DAYS);

        $dietPlan
            ->getMealsQuantity()
            ->willReturn(DietType::MEALS_QUANTITY_FIVE);

        $dietPlan
            ->getType()
            ->willReturn($dietType->reveal());

        $dietPlan
            ->getOption()
            ->willReturn($dietOption->reveal());

        $this->generateDietValidator
            ->isValid($generateDietCommand)
            ->willReturn(true);

        $this->ownerRepository
            ->findOneByEmail($generateDietCommand->getEmail())
            ->willReturn($owner->reveal());

        $this->dietPlanRepository
            ->findForOwner($owner)
            ->willReturn($dietPlan->reveal());

        $this->calorieCalculator
            ->calculatePermissibleMealCalories($owner, $dietType, Argument::type('integer'))
            ->shouldBeCalledTimes(DietOption::STANDARD_QUANTITY_DAYS * DietType::MEALS_QUANTITY_FIVE)
            ->willReturn(new Calorie(500));

        $this->mealRepository
            ->findAllInCalorieRangeWithoutMeat(Argument::type(Calorie::class))
            ->shouldBeCalledTimes(DietType::MEALS_QUANTITY_FIVE)
            ->willReturn([]);

        $this->mealRepository
            ->findRandomInCalorieRange(Argument::type(Calorie::class), [])
            ->shouldBeCalledTimes(DietOption::STANDARD_QUANTITY_DAYS * DietType::MEALS_QUANTITY_FIVE)
            ->willReturn($meal->reveal());

        $this->periodRepository
            ->save(Argument::type(Period::class))
            ->shouldBeCalledTimes(1);

        $this->generateDietHandler->handle($generateDietCommand);
    }
}
