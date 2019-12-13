<?php

declare(strict_types=1);

namespace App\Diet\Application\Service;

interface PdfGeneratorInterface
{
    public function generate(array $dataToPdf): void;
}
