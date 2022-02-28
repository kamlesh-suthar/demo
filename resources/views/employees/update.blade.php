@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Employees Update</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('employees.update', ['employee' => $employee->id]) }}" id="createClient">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="Name">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="name" value="{{ $employee->name }}">
                                    <span id="name-error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="Department">Department <span class="text-danger">*</span></label>
                                    <input type="text" id="department" class="form-control" name="department" placeholder="Enter Employee Department" value="{{  $employee->department }}">
                                    <span id="department-error" class="text-danger">{{ $errors->first('department') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="joining_date">Joining Date <span class="text-danger">*</span></label>
                                    <input type="text" id="joining_date" class="form-control" name="joining_date" placeholder="Enter Joining Date" value="{{ $employee->joined_at }}">
                                    <span id="joining_date-error" class="text-danger">{{ $errors->first('joining_date') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="active_subscribers_limit">Status<span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $employee->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $employee->status == 0 ? 'selected' : '' }}>In-active</option>
                                    </select>
                                    <span id="email-error" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('employees.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" id="btn" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-javascript')
    <script>
        $(document).ready(function () {
            $('#updateClient, #createClient').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 1,
                        maxlength: 150
                    },
                    department: {
                        required: true,
                        minlength: 1,
                        maxlength: 150
                    },
                    joining_date: {
                        required: true,
                        minlength: 1,
                        maxlength: 150
                    },
                    status: {
                        required:true
                    }
                },
                messages: {
                    name: {
                        required: "The name field is required",
                        minlength: "Min 1 char required",
                        maxlength: "max 150 char only"
                    },
                    department: {
                        required: "The department field is required",
                        minlength: "Min 1 char required",
                        maxlength: "max 150 char only"
                    },
                    joining_date: {
                        required: "The joining date field is required",
                        minlength: "Min 1 char required",
                        maxlength: "max 150 char only"
                    },
                    status: "The status field is required"
                },
                submitHandler: function(form) {

                    formId = form.id;

                    formAction = $("#createClient").attr('action');
                    formMethod = 'patch';

                    $.ajax({
                        url: formAction,
                        type: formMethod,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:  $("#" + formId).serialize(),
                        success: function (response) {
                            if (response.status == "success") {
                                window.location.href = '{{ route("employees.index") }}';

                            }
                        },
                        error: function (xhr, status, error) {
                            responseText = jQuery.parseJSON(xhr.responseText);
                            jQuery.each(responseText.errors, function (key, value) {
                                $("#" + formId + " #" + key + "-error").parent().parent().addClass('is-invalid');
                                $("#" + formId + " #" + key + "-error").html(value);
                            });
                        }
                    })
                }
            });
        });
    </script>
@endsection