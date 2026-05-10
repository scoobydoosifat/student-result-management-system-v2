<?php

namespace App\Modules\Mithila\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class TranscriptPdfService
{
    public function download(array $data)
    {
        return Pdf::loadView('mithila.transcript', $data);
    }
}
