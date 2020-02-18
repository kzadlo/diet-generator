<?php

declare(strict_types=1);

namespace App\Diet\Application\Service;

use App\Diet\Application\Exception\DayNameNotFoundException;

class DayNameTranslator
{
    public static $dayMap = [
        'mon' => 'Poniedziałek',
        'tue' => 'Wtorek',
        'wed' => 'Środa',
        'thu' => 'Czwartek',
        'fri' => 'Piątek',
        'sat' => 'Sobota',
        'sun' => 'Niedziela'
    ];

    public static function map(string $dayShortcut): string
    {
        $dayShortcut = mb_strtolower($dayShortcut);

        if (!array_key_exists($dayShortcut, self::$dayMap)) {
            throw new DayNameNotFoundException('Day with this shortcut does not exist.');
        }

        return self::$dayMap[$dayShortcut];
    }
}
