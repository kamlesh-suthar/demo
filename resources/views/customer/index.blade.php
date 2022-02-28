@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Projects</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="customers" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td><input type="text" class="form-control filter-input" placeholder="Search for First Name" data-column="1"></td>
                                <td><input type="text" class="form-control filter-input" placeholder="Search for Last Name" data-column="2"></td>
                                <td><input type="text" class="form-control filter-input" placeholder="Search for Email" data-column="3"></td>
                                <td></td>
                            </tr>
                            </tfoot>
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
//                orderable: false
                ajax: "{{ route('customers.index') }}",
                columns: [
                    {name: 'id', data: 'id'},
                    {name: 'first_name', data: 'first_name'},
                    {name: 'last_name', data: 'last_name'},
                    {name: 'email', data: 'email'},
                    {name: 'action', data: ''},
                ],
                // remove first name and last name two different column and merge into one single column
                columnDefs: [
//                    {
//                        "render": function (data, type, row) {
//                            return data + ' ' + row['last_name'];
//                        },
//                        "targets": 1
//                    },
//                    {
//                        "visible": false, "targets": [2]
//                    },
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
//                pageLength: 100,
//                lengthMenu: [10,25,50,100,200,400],
//               buttons: ['colvis'],
//               dom: 'lfrtipB',
               dom: 'frtip  '
            });
            $('.filter-input').keyup(function () {
               table.column($(this).data('column')).search($(this).val()).draw();
            });
        });
    </script>
@endsection