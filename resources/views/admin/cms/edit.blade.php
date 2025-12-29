<x-admin-layout>
    @section('title', 'Edit CMS Page')
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item">
                            <a href="#">
                                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.cms.index') }}">CMS Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit CMS Page</li>
                    </ol>
                </nav>
                <h2 class="h4">Edit CMS Page</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.cms.update', $cmsPage->id) }}" method="POST" id="editCmsForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="title">Title</label>
                                    <input class="form-control @error('title') is-invalid @enderror"
                                        id="title" type="text" placeholder="Title"
                                        name="title" value="{{ old('title', $cmsPage->title) }}">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="meta_title">Meta Title</label>
                                    <input class="form-control @error('meta_title') is-invalid @enderror"
                                        id="meta_title" type="text" placeholder="Meta title"
                                        name="meta_title" value="{{ old('meta_title', $cmsPage->meta_title) }}">
                                    @error('meta_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="meta_description">Meta Description</label>
                                    <input class="form-control @error('meta_description') is-invalid @enderror"
                                        id="meta_description" type="text" placeholder="Meta description"
                                        name="meta_description" value="{{ old('meta_description', $cmsPage->meta_description) }}">
                                    @error('meta_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="slug">Slug</label>
                                    <input class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" type="text" placeholder="Slug"
                                        name="slug" value="{{ old('slug', $cmsPage->slug) }}" readonly>
                                    <small class="form-text text-muted">The slug is automatically generated and cannot be changed.</small>
                                    @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="tag_line">Tag Line</label>
                                    <input class="form-control @error('tag_line') is-invalid @enderror"
                                        id="tag_line" type="text" placeholder="Tag Line"
                                        name="tag_line" value="{{ old('tag_line', $cmsPage->tag_line) }}">
                                    @error('tag_line')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="editor">Content</label>
                                    <div id="editor" class="@error('content') is-invalid @enderror">
                                        {!! old('content', $cmsPage->content) !!}
                                    </div>
                                    <input type="hidden" id="content" name="content" value="{{ old('content', $cmsPage->content) }}">
                                    <span class="invalid-txt" role="alert" style="display:none"></span>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Update</button>
                            <a href="{{ route('admin.cms.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            #editor {
                min-height: 300px; /* Adjust as needed */
            }
        </style>
    @endpush
    @push('scripts')
    <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js')}}"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script>
            const toolbarOptions = [
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],
                [{ size: ["small", false, "large", "huge"] }],
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ align: [] }],
            ];

            const quill = new Quill("#editor", {
                modules: {
                    toolbar: toolbarOptions,
                },
                theme: "snow",
            });

            // Set the initial content of the editor
            quill.root.innerHTML = document.querySelector('#content').value;

            const errorSpan = document.querySelector(".invalid-txt");
            let hasError = false;

            quill.on("text-change", function(delta, oldDelta, source) {
                validateText();
                if (source === 'user') {
                    $(document).trigger('quill-content-changed');
                }
            });

            quill.on("text-change", validateText);

            function validateText() {
                const len = quill.getLength();
                const text = quill.getText();
                if (text.trim() === "") {
                    showError("Content field can't be empty");
                    hasError = true;
                } else if (len < 50) {
                    showError("Content must be at least 50 characters");
                    hasError = true;
                } else if (len > 5000) {
                    showError("Content must be at most 5000 characters");
                    hasError = true;
                } else {
                    hideError();
                    hasError = false;
                }
            }

            function showError(message) {
                errorSpan.style.display = "block";
                errorSpan.textContent = message;
            }

            function hideError() {
                errorSpan.style.display = "none";
            }

            const rules = {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },
                meta_title: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },
                meta_description: {
                    required: true,
                    minlength: 3,
                    maxlength: 160,
                },
                tag_line: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },
            };

            const messages = {
                title: {
                    required: "Title is required",
                    minlength: "Title must be at least 3 characters",
                    maxlength: "Title cannot exceed 100 characters",
                },
                meta_title: {
                    required: "Meta title is required",
                    minlength: "Meta title must be at least 3 characters",
                    maxlength: "Meta title cannot exceed 100 characters",
                },
                meta_description: {
                    required: "Meta description is required",
                    minlength: "Meta description must be at least 3 characters",
                    maxlength: "Meta description cannot exceed 160 characters",
                },
                tag_line: {
                    required: "Tag line is required",
                    minlength: "Tag line must be at least 3 characters",
                    maxlength: "Tag line cannot exceed 100 characters",
                },
            };

            function handleValidation(formId, rules, messages = {}) {
                $("#" + formId).validate({
                    rules: rules,
                    messages: messages,
                    errorElement: "span",
                    errorClass: "invalid-feedback",
                    highlight: function(element) {
                        $(element).addClass("is-invalid");
                    },
                    unhighlight: function(element) {
                        $(element).removeClass("is-invalid");
                    },
                });
            }

            handleValidation("editCmsForm", rules, messages);

            document.getElementById('editCmsForm').addEventListener('submit', function(e) {
                e.preventDefault();
                validateText();
                if (!hasError && $(this).valid()) {
                    document.getElementById("content").value = quill.root.innerHTML;
                    $('.save-all-btn').prop('disabled', true);
                    $('.overlay').css('display', 'block');
                    this.submit();
                }
            });
        </script>
    @endpush
</x-admin-layout>