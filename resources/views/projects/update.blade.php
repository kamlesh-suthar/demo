@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Project Update</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('projects.update', ['project' => $project->id]) }}" id="createClient">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="Name">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="name" value="{{ $project->name }}">
                                    <span id="name-error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="active_subscribers_limit">Status<span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $project->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $project->status == 0 ? 'selected' : '' }}>In-active</option>
                                    </select>
                                    <span id="email-error" class="text-danger"></span>
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
            $('#updateClient, #createClient').validate({
                rules: {
                    name: {
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
                        required: "Enter Name",
                        minlength: "Min 1 char required",
                        maxlength: "max 150 char only"
                    },
                    status: "Status required"
                },
                submitHandler: function(form) {
                    var name = $('#name').val();
                    var status = $('#status').val();

                    formId = form.id;

                    formAction = $("#createClient").attr('action');
                    formMethod = 'PATCH';

                    $.ajax({
                        url: formAction,
                        type: formMethod,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'name': name,
                            'status': status
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                window.location.href = '{{ route("projects.index") }}';

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