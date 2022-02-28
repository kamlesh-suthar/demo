<?php

namespace App\Services\Reports;

use App\Interfaces\ReportDownloadServiceInterface;

class ReportDownloadCsvService implements ReportDownloadServiceInterface
{

    public function download()
    {
        return 'CSV for download';
    }

}