<?php

namespace App\Diet\Tests\Application\Service;

use App\Diet\Application\Exception\DayNameNotFoundException;
use App\Diet\Application\Service\DayNameTranslator;
use PHPUnit\Framework\TestCase;

class DayNameTranslatorTest extends TestCase
{
    /** @dataProvider provideWrongDayShortcuts */
    public function testCannotMapOtherStringThanDayShortcut(string $dayShortcut): void
    {
        $this->expectException(DayNameNotFoundException::class);
        $this->expectExceptionMessage('Day with this shortcut does not exist.');

        DayNameTranslator::map($dayShortcut);
    }

    /** @dataProvider provideDayShortcuts */
    public function testCanMapDayShortcutToPolishName(string $dayShortcut, string $dayPolishName): void
    {
        $this->assertSame($dayPolishName, DayNameTranslator::map($dayShortcut));
    }

    public function provideWrongDayShortcuts(): array
    {
        return [
            'Day shortcut with number' => [
                'dayShortcut' => '0Thu'
            ],
            'Random string' => [
                'dayShortcut' => 'xdqweq32rfe'
            ],
            'Long day name' => [
                'dayShortcut' => 'sunday'
            ],
            'Number of day' => [
                'dayShortcut' => '01'
            ],
            'Polish shortcut' => [
                'dayShortcut' => 'Pon'
            ]
        ];
    }

    public function provideDayShortcuts(): array
    {
        return [
            [
                'dayShortcut' => 'Mon',
                'dayPolishName' => 'Poniedziałek'
            ],
            [
                'dayShortcut' => 'MON',
                'dayPolishName' => 'Poniedziałek'
            ],
            [
                'dayShortcut' => 'mon',
                'dayPolishName' => 'Poniedziałek'
            ]
        ];
    }
}
