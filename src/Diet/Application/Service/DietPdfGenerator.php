<?php

declare(strict_types=1);

namespace App\Diet\Application\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;

class DietPdfGenerator implements PdfGeneratorInterface
{
    public const DIRECTORY_PATH = 'var/file/pdf/diet/';

    private $pdf;

    private $twig;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function generate(array $dataToPdf): void
    {
        $fileName = 'diet_period_start_' . key($dataToPdf['periodDays']) . '.pdf';
        $html = $this->twig->render(
            'diet-pdf.html.twig',
            [
                'periodDays' => $dataToPdf['periodDays'],
                'periodRecipes' => $dataToPdf['periodRecipes'],
                'periodIngredients' => $dataToPdf['periodIngredients']
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
