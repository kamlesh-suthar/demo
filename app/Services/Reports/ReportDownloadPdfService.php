<?php

namespace App\Services\Reports;

use App\Interfaces\ReportDownloadServiceInterface;

class ReportDownloadPDFService implements ReportDownloadServiceInterface
{

    public function download()
    {
        return 'PDF for download';
    }

}