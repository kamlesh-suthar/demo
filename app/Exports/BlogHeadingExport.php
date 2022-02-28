<?php

namespace App\Exports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BlogHeadingExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Blog::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'User Details',
            'Title',
            'Description',
            'Published At',
            'Created At',
            'Updated At'
        ];
    }
}
