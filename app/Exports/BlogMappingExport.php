<?php

namespace App\Exports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class BlogMappingExport implements FromCollection, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Blog::with('user')->get();
    }

    /**
     * @param $blog
     * @return array
     */
    public function map($blog): array
    {
        return [
            $blog->id,
            $blog->user->name,
            $blog->title,
            $blog->description,
            $blog->published_at,
            $blog->created_at->toDateString(),
            $blog->updated_at->toDateString()
        ];
    }
}
