<?php

declare(strict_types=1);

namespace App\Diet\Application\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;

class DietPdfGenerator
{
    public const DIRECTORY_PATH = 'var/file/pdf/diet/';

    private $pdf;

    private $twig;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function generate(array $periodMeals, array $periodRecipes, array $periodIngredients): void
    {
        $fileName = 'diet_period_start_' . key($periodMeals) . '.pdf';
        $html = $this->twig->render(
            'diet-pdf.html.twig',
            [
                'periodMeals' => $periodMeals,
                'periodRecipes' => $periodRecipes,
                'periodIngredients' => $periodIngredients
            ]
        );

        $this->pdf->generateFromHtml(
            $html,
            self::DIRECTORY_PATH . $fileName,
            [
                'margin-top' => 12,
                'margin-bottom' => 12,
                'margin-right' => 10,
                'margin-left' => 10
            ]
        );
    }
}
