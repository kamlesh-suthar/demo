@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h3 mb-4 text-gray-800">Blog Create</h1>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('blog.store') }}" id="createClient" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="name">Title <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="title" placeholder="Enter Title" value="{{ old('title') }}">
                                    <span id="title-error" class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="Department">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10" placeholder="Enter Description">{{ old('description') }}</textarea>
                                    <span id="description-error" class="text-danger">{{ $errors->first('description') }}</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="published">Published <span class="text-danger">*</span></label>
                                    <input type="checkbox" id="published" name="published" value="1" {{ old('published') == 1 ? 'checked' : '' }}>
                                    <span id="published-error" class="text-danger">{{ $errors->first('published') }}</span>
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
            const inputElement = document.querySelector('input[type="file"]');
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server: {
                    url: '/employees/image-upload',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
            });
            $('#updateClient, #createClient').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 1,
                        maxlength: 150
                    },
                    description: {
                        required: true,
                        minlength: 1,
                        maxlength: 150
                    },
                    published_at: {
                        required: true,
                        minlength: 1,
                        maxlength: 150
                    },
                },
                messages: {
                    title: {
                        required: "The title field is required",
                        minlength: "Min 1 char required",
                        maxlength: "max 150 char only"
                    },
                    description: {
                        required: "The description field is required",
                        minlength: "Min 1 char required",
                        maxlength: "max 150 char only"
                    },
                    published_at: {
                        required: "The published field is required",
                    },
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
                                window.location.href = '{{ route("blog.index") }}';
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