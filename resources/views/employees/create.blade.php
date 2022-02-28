@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Employee Create</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('employees.store') }}" id="createClient" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="Enter Project Name" value="{{ old('name') }}">
                                    <span id="name-error" class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="Department">Department <span class="text-danger">*</span></label>
                                    <input type="text" id="department" class="form-control" name="department" placeholder="Enter Employee Department" value="{{ old('department') }}">
                                    <span id="department-error" class="text-danger">{{ $errors->first('department') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="joining_date">Joining Date <span class="text-danger">*</span></label>
                                    <input type="text" id="joining_date" class="form-control" name="joining_date" placeholder="Enter Joining Date" value="{{ old('joining_date') }}">
                                    <span id="joining_date-error" class="text-danger">{{ $errors->first('joining_date') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="active_subscribers_limit">Status<span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('status') && old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') && old('status') == 0 ? 'selected' : '' }}>In-active</option>
                                    </select>
                                    <span id="status-error" class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="joining_date">Image <span class="text-danger">*</span></label>
                                    <input type="file" id="image" class="form-control" name="image" placeholder="Upload Image" value="{{ old('image') }}">
                                    <span id="image-error" class="text-danger">{{ $errors->first('image') }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('projects.index') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" id="btn" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-javascript')
    <script>
        $(document).ready(function () {

            const inputElement = document.querySelector('input[id="image"]');
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server : {
                    url: '{{ route('employee.image-upload') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }
            });

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
                    },
                    image: {
                        required:true,
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
                    formMethod = 'POST';


                    $.ajax({
                        url: formAction,
                        type: formMethod,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: new FormData(form),
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