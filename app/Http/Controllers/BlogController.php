<?php

namespace App\Http\Controllers;

use App\Exports\BlogAutoSizwExport;
use App\Exports\BlogHeadingExport;
use App\Exports\BlogMappingExport;
use App\Exports\BlogOrganizationExport;
use App\Exports\BlogsExport;
use App\Imports\BlogImport;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::select('id', 'user_id', 'title', 'description', 'published_at')
                ->where('user_id', auth()->user()->id);
            return datatables($blogs)->toJson();
        }
//        return view('blog.index');
        return view('blog.table-view', [
            'blogs' => Blog::select(['title', 'description'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Blog::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'published_at' => $request->published ? now()->toDateString() : null
        ]);

        return response()->json([
            'message' => 'Blog created successfully',
            'status'  => 'success',
            'code'    => 200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }

    public function export()
    {
        return Excel::download(new BlogsExport(), 'blogs.xlsx', \Maatwebsite\Excel\Excel::XLSX);
//        return Excel::download(new BlogsExportView(), 'blogs.xlsx');
    }

    public function exportFormat($format)
    {
        if ($format == 'CSV') {
            $newFormat = \Maatwebsite\Excel\Excel::CSV;
        } elseif ($format == 'PDF') {
            $newFormat = \Maatwebsite\Excel\Excel::DOMPDF;
        } elseif ($format == 'HTML') {
            $newFormat = \Maatwebsite\Excel\Excel::HTML;
        } else {
            $newFormat = \Maatwebsite\Excel\Excel::HTML;
        }

        return Excel::download(new BlogsExport(), 'blogs.' . strtolower($format), $newFormat);
//        return Excel::download(new BlogsExportView(), 'blogs.xlsx');
    }

    public function exportSheets()
    {
        return Excel::download(new BlogOrganizationExport(), 'blogs.xlsx');
    }

    public function exportHeading()
    {
        return Excel::download(new BlogHeadingExport(), 'blogs.xlsx');
    }

    public function exportMapping()
    {
        return Excel::download(new BlogMappingExport(), 'blogs.xlsx');
    }

    public function exportAutoSize()
    {
        return Excel::download(new BlogAutoSizwExport(), 'blogs.xlsx');
    }

    public function import()
    {
        Excel::import(new BlogImport(), \request()->file('import'));
        return redirect()->back()->withMessage('Successfully Imported');
    }
}
