<?php

namespace App\Services\Reports;

class ReportDownloadService
{
    /**
     * @param string $format
     * @return \never
     */
    public function downloadReport($format = 'html')
    {
        try {
            $className = 'App\Services\Reports\ReportDownload' . ucfirst($format) . 'Service';
            return (new $className)->download();
        } catch (\Exception $ex) {
            return abort(404, 'Download format not found');
        }
    }
}