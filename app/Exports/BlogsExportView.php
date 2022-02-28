<?php

namespace App\Exports;

use App\Models\Blog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BlogsExportView implements FromView
{
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function view(): View
    {
        return view('blog.table', [
            'blogs' => Blog::select(['title', 'description'])->get()
        ]);
    }
}
