@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Projects</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('blog.export') }}" class="btn btn-primary me-2">Excel</a>
                        <a href="{{ route('blog.create') }}" class="btn btn-primary me-2">Add New Blog</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="customers" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Published Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-javascript')
    <script type="text/javascript">
        $(document).ready(function(){
            var table = $('#customers').DataTable({
                processing: true,
                serverSide: true,
                searchable: false,
                ajax: "{{ route('blog.index') }}",
                columns: [
                    {name: 'id', data: 'id'},
                    {name: 'user_id', data: 'user_id'},
                    {name: 'title', data: 'title'},
                    {name: 'description', data: 'description'},
                    {name: 'published_at', data: 'published_at'},
                    {name: 'action', data: ''},
                ],
                columnDefs: [
                    {
                        "render": function (data, type, row) {
                            return '<div class="d-flex"><a href="/{{ request()->segment(1) }}/'+ row['id']+'/edit" class="btn btn-primary me-2">Edit</a>' +
                                '<form action="/{{ request()->segment(1) }}/' + row['id'] +'" method="post">' +
                                '<input type="hidden" name="_method" value="DELETE">  {{ csrf_field() }} ' +
                                '<input type="submit" value="delete"  class="btn btn-danger me-2">' +
                                '</form>' + '</div>';
                        },
                        "targets": -1
                    }
                ],
                order: [[0, 'desc']],
            });
        });
    </script>
@endsection