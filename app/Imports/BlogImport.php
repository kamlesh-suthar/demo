<?php

namespace App\Imports;

use App\Models\Blog;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class BlogImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Blog([
            'user_id' => $row[1],
            'title'        => $row[2],
            'description'  => $row[3],
            'published_at' => $row[4] ? Carbon::parse($row[4])->toDateString() : null,
        ]);
    }
}
