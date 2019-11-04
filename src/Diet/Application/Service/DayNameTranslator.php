<?php

declare(strict_types=1);

namespace App\Diet\Application\Service;

class DayNameTranslator
{
    public static $dayMap = [
        'Mon' => 'Poniedziałek',
        'Tue' => 'Wtorek',
        'Wed' => 'Środa',
        'Thu' => 'Czwartek',
        'Fri' => 'Piątek',
        'Sat' => 'Sobota',
        'Sun' => 'Niedziela'
    ];

    public static function map(string $month): string
    {
        return self::$dayMap[$month];
    }
}
