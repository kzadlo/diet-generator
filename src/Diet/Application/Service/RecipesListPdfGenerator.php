<?php

declare(strict_types=1);

namespace App\Diet\Application\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;

class RecipesListPdfGenerator implements PdfGeneratorInterface
{
    public const DIRECTORY_PATH = 'var/file/pdf/recipes_list/';

    private $pdf;

    private $twig;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function generate(array $dataToPdf): void
    {
        $fileName = 'recipes_list_' . (new \DateTime())->format('Y-m-d') . '.pdf';
        $html = $this->twig->render(
            'recipes-list-pdf.html.twig',
            [
                'recipes' => $dataToPdf['recipes']
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
