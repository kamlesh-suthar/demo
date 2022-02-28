@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Blogs</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('blog.import') }}" id="createClient" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="file" id="import" class="form-control" name="import" placeholder="Upload File">
                                    <span id="title-error" class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('blog.export_sheets') }}" class="btn btn-primary me-2">Multiple Sheet</a>
                        <a href="{{ route('blog.export_autosize') }}" class="btn btn-primary me-2">Auto Size Sheet</a>
                        <a href="{{ route('blog.export_mapping') }}" class="btn btn-primary me-2">Mapping Sheet</a>
                        <a href="{{ route('blog.export_heading') }}" class="btn btn-primary me-2">Export With Heading</a>
                        <a href="{{ route('blog.export') }}" class="btn btn-primary me-2">Excel</a>
                        <a href="{{ route('blog.export_format', ['format' => 'CSV']) }}" class="btn btn-primary me-2">CSV</a>
                        <a href="{{ route('blog.export_format', ['format' => 'HTML']) }}" class="btn btn-primary me-2">HTML</a>
                        <a href="{{ route('blog.export_format', ['format' => 'PDF']) }}" class="btn btn-primary me-2">PDF</a>
                        <a href="{{ route('blog.create') }}" class="btn btn-primary me-2">Add New Blog</a>
                    </div>
                    <div class="table-responsive">
                        @include('blog.table', $blogs)
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection