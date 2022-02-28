<?php

namespace App\Exports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class BlogMultipleExport implements FromCollection, WithTitle
{
    private $organization;

    public function __construct($organization)
    {
        $this->organization = $organization;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Blog::select(['title', 'description', 'published_at'])->where('title', 'like', '%' . $this->organization)->get();
    }

    public function title(): string
    {
        return 'Organization ' . $this->organization;
    }
}
