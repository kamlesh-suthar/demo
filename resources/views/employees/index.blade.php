@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Employees</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-start mb-2">
                            <button class="btn btn-danger me-5" onclick="deleteClient()">Delete</button>
                            <a class="btn btn-primary me-5" href="{{ route('employee.report', ['format' => 'pdf']) }}">PDF</a>
                            <a class="btn btn-primary me-5" href="{{ route('employee.report', ['format' => 'csv']) }}">CSV</a>
                            <a href="{{ route('employees.create') }}" class="btn btn-primary">Add New Employee</a>
                        </div>
                        <table class="table table-bordered" id="clients" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th data-orderable="false">
                                    <div class="checkbox-inline">
                                        <div class="checkbox-inline">
                                            <input type="checkbox" id="selectAll" class="checkbox-inline">
                                            <label for="selectAll"></label>
                                        </div>
                                    </div>
                                </th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Joined At</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th data-orderable="false" width="142px">Action</th>
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
    <script>
        $(document).ready(function(){
            $.fn.dataTable.ext.errMode = 'throw';
            $('#clients').DataTable({
                "ajax":{
                    "url": "{{ route('employees.index') }}",
                    "type": "GET",
                    dataType:"json",
                    "data": function(d){
                        d.id=$("#id").val();
                        d.name=$("#name").val();
                        d.status=$("#status").val();
                    }
                },
                "searching": true,
                "processing": true,
                "serverSide": true,
                "order": [[ 0, 'DESC' ]],
                "columns": [
                    {"name": "id"},
                    {"name": "id"},
                    {"name": "name"},
                    {"name": "department"},
                    {"name": "joined_at"},
                    {"name": "status"},
                    {"name": "image"},
                    {"name": "action", "class": "action-col"}
                ],
                "drawCallback": function(settings) {
                    $('.chkbox').on('click', function() {
                        $('#selectAll').prop('checked', ($('.chkbox').length == $('.chkbox:checked').length));
                        clientChange();
                    });
                },
                "dom": '<"top"rf>t<"bottom"pli>'
            });
        });
        $('#selectAll').on('click', function() {
            $('.chkbox').prop('checked', $(this).is(':checked'));
            clientChange();
        });
        function clientChange(){
            if($('.chkbox:checked').length > 0){
                $("#change").removeClass('hide');
            }else{
                $("#change").addClass('hide');
            }
        }
        function deleteClient() {
            bootbox.confirm({
                message: "Are you sure?",
                buttons: {
                    'cancel': {
                        label: 'Cancel'
                    },
                    'confirm': {
                        label: 'Confirm'
                    }
                },
                callback: function(result) {

                    var arrselectIds = [];

                    $('.chkbox:checked').each(function() {
                        arrselectIds.push($(this).data('id'));
                    });

                    if (result) {
                        if (arrselectIds.length) {
                            $.ajax({
                                url: '{{ route("employees.destroy", "") }}/'+arrselectIds,
                                type: 'DELETE',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: 'ids='+arrselectIds,
                                success: function (response) {
                                    $('#selectAll').prop("checked", false);
                                    $('#clients').DataTable().ajax.reload();
                                    $('#id').val('');
                                    if (response.status == "success") {
                                        $message = '<p class="mt-3 alert alert-success">' + response.message + '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: #0f5132; text-decoration: none">&times;</a></p>';
                                        $(".flash-message").html($message);
                                        $('.flash-message .alert').not('.alert-important').delay(5000).slideUp(350);
                                    }
                                },
                                error: function (response) {
                                    $message = '<p class="mt-3 alert alert-danger">' + error_occurred + '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: #0f5132; text-decoration: none">&times;</a></p>';
                                    $(".flash-message").html($message);
                                    $('.flash-message .alert').not('.alert-important').delay(5000).slideUp(350);
                                }
                            });
                        }
                        else {
                            $message = '<p class="mt-3 alert alert-danger">Try Again<a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: #0f5132; text-decoration: none">&times;</a></p>';
                            $(".flash-message").html($message);
                            $('.flash-message .alert').not('.alert-important').delay(5000).slideUp(350);
                        }
                    }
                }
            });
        }
        function deleteRecord(id)
        {
            bootbox.confirm({
                message: "delete",
                buttons: {
                    'cancel': {
                        label: 'Cancel'
                    },
                    'confirm': {
                        label: 'Delete'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $.ajax({
                            url: '{{ route("employees.destroy", "") }}/'+id,
                            type: 'DELETE',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: 'ids='+id,
                            success: function (response) {
                                $('#clients').DataTable().ajax.reload();
                                if (response.status == "success") {
                                    $message = '<p class="mt-3 alert alert-success">' + response.message + '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: #0f5132; text-decoration: none">&times;</a></p>';
                                    $(".flash-message").html($message);
                                    $('.flash-message .alert').not('.alert-important').delay(5000).slideUp(350);
                                }
                            },
                            error: function (response) {
                                $message = '<p class="mt-3 alert alert-danger">' + error_occurred + '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="float: right; color: #0f5132; text-decoration: none">&times;</a></p>';
                                $(".flash-message").html($message);
                                $('.flash-message .alert').not('.alert-important').delay(5000).slideUp(350);
                            }
                        });
                    }
                }
            });
        }
    </script>
@endsection