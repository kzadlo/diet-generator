<?php

declare(strict_types=1);

namespace App\Diet\Tests\Application\Command;

use App\Diet\Application\Command\GenerateDiet;
use App\Diet\Application\Command\GenerateDietValidator;
use App\Diet\Domain\Model\Owner;
use App\Diet\Domain\Repository\OwnerRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GenerateDietValidatorTest extends TestCase
{
    private $ownerRepository;

    private $generateDietValidator;

    protected function setUp(): void
    {
        $this->ownerRepository = $this->prophesize(OwnerRepositoryInterface::class);

        $this->generateDietValidator = new GenerateDietValidator($this->ownerRepository->reveal());
    }

    public function testIsInvalidWhenGivingNonExistentOwnerEmail(): void
    {
        $generateDietCommand = new GenerateDiet('non-existent-owner@email.pl', '2019-12-12');

        $this->ownerRepository
            ->findOneByEmail($generateDietCommand->getEmail())
            ->willReturn(null);

        $this->assertFalse($this->generateDietValidator->isValid($generateDietCommand));
        $this->assertNotNull($this->generateDietValidator->getErrorMessage());
    }

    public function testIsValidWhenGivingExistentOwnerEmail(): void
    {
        $generateDietCommand = new GenerateDiet('existent-owner@email.pl', '2019-12-12');
        $owner = $this->prophesize(Owner::class);

        $this->ownerRepository
            ->findOneByEmail($generateDietCommand->getEmail())
            ->willReturn($owner->reveal());

        $this->assertTrue($this->generateDietValidator->isValid($generateDietCommand));
        $this->assertNull($this->generateDietValidator->getErrorMessage());
    }

    /** @dataProvider provideWrongFormattedDates */
    public function testIsInvalidWhenGivingWrongFormattedDate(string $date): void
    {
        $generateDietCommand = new GenerateDiet('existent-owner@email.pl', $date);
        $owner = $this->prophesize(Owner::class);

        $this->ownerRepository
            ->findOneByEmail($generateDietCommand->getEmail())
            ->willReturn($owner->reveal());

        $this->assertFalse($this->generateDietValidator->isValid($generateDietCommand));
        $this->assertNotNull($this->generateDietValidator->getErrorMessage());
    }

    public function testIsValidWhenGivingCorrectFormattedDate(): void
    {
        $generateDietCommand = new GenerateDiet('existent-owner@email.pl', '2019-03-02');
        $owner = $this->prophesize(Owner::class);

        $this->ownerRepository
            ->findOneByEmail($generateDietCommand->getEmail())
            ->willReturn($owner->reveal());

        $this->assertTrue($this->generateDietValidator->isValid($generateDietCommand));
        $this->assertNull($this->generateDietValidator->getErrorMessage());
    }

    public function provideWrongFormattedDates(): array
    {
        return [
            'Date formatted: Y.m.d' => [
                'date' => '2019.03.02'
            ],
            'Date formatted: d-m-Y' => [
                'date' => '02-03-2019'
            ],
            'Date formatted: m.Y' => [
                'date' => '03.2019'
            ],
            'Date formatted: m-Y' => [
                'date' => '03-2019'
            ],
            'Date formatted: d-m' => [
                'date' => '02-03'
            ],
            'Date formatted: Y-m-d H:i:s' => [
                'date' => '2019-03-02 10:33:12'
            ],
        ];
    }
}
