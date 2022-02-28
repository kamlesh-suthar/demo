<?php

namespace App\Exports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BlogOrganizationExport implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $organizations = [1,2,3];

        foreach ($organizations as $organization) {
            $sheets[] = new BlogMultipleExport($organization);
        }

        return $sheets;
    }
}
