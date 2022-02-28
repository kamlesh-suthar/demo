<?php

namespace App\Services\Reports;

use App\Interfaces\ReportDownloadServiceInterface;

class ReportDownloadJsonService implements ReportDownloadServiceInterface
{

    public function download()
    {
        return 'Json for download';
    }

}