<x-admin-layout>
    @section('title', 'Edit Email Template')

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.email-templates.index') }}">Email Template List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Email Template</li>
                    </ol>
                </nav>
                <h2 class="h4">Edit Email Template - {{ $emailTemplate->name }}</h2>
            </div>
        </div>

        @include('admin.common.notification')

        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.email-templates.update', $emailTemplate->id) }}" method="POST" id="create-email-template" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Important for update requests --}}

                        {{-- Include the shared form partial, passing the $emailTemplate object --}}
                        @include('admin.email_templates._form', ['emailTemplate' => $emailTemplate])

                        {{-- Form Actions --}}
                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save me-1"></i>
                                Update Template
                            </button>
                            <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Helper Sidebar --}}
            @include('admin.email_templates._helper_sidebar')
        </div>
    </div>

    @push('styles')
        {{-- Quill.js CSS --}}
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            /* Custom Quill styles (keep these here or in a global CSS) */
            .ql-toolbar {
                border-radius: 0.375rem 0.375rem 0 0 !important;
                border-bottom: none !important;
            }

            .ql-container {
                border-radius: 0 0 0.375rem 0.375rem !important;
                font-family: inherit;
            }

            .ql-editor {
                min-height: 300px;
                font-size: 14px;
                line-height: 1.5;
            }

            .ql-editor p {
                margin-bottom: 1rem;
            }

            /* Custom variable button styling */
            .ql-variable {
                width: auto !important;
            }

            .ql-variable .ql-stroke {
                stroke: #28a745;
            }
        </style>
    @endpush

    @push('scripts')
        {{-- Quill.js JavaScript --}}
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Custom Quill toolbar configuration
                const toolbarOptions = [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['blockquote', 'code-block'],
                    ['clean'],
                    ['variable'] // Our custom variable button
                ];

                // Initialize Quill editor
                const quill = new Quill('#quill-editor', {
                    modules: {
                        toolbar: {
                            container: toolbarOptions,
                            handlers: {
                                'variable': function() {
                                    insertVariableHandler();
                                }
                            }
                        }
                    },
                    theme: 'snow',
                    placeholder: 'Start typing your email content here...'
                });

                // Custom variable insertion handler
                function insertVariableHandler() {
                    const variableName = prompt('Enter variable name (e.g., user_name, order_total):');

                    if (variableName && variableName.trim()) {
                        const cleanVarName = variableName.trim().replace(/[^a-zA-Z0-9_]/g, '');

                        if (cleanVarName) {
                            const range = quill.getSelection(true);
                            // Corrected insertion for Blade variable syntax
                            const variableText = `@{{ $${cleanVarName} }}`;

                            // Insert the variable with special formatting
                            quill.insertText(range.index, variableText, {
                                'background': '#e3f2fd',
                                'color': '#1976d2',
                                'bold': true
                            });

                            // Move cursor after the inserted variable
                            quill.setSelection(range.index + variableText.length);
                        } else {
                            alert('Please enter a valid variable name (letters, numbers, and underscores only).');
                        }
                    }
                }

                // Set initial content if there's old input OR existing data (for edit)
                const initialContent = document.getElementById('body').value;
                if (initialContent) {
                    quill.root.innerHTML = initialContent;
                }

                // Sync editor content with hidden textarea
                function syncContent() {
                    const bodyTextarea = document.getElementById('body');
                    bodyTextarea.value = quill.root.innerHTML; // Get HTML content
                }

                // Update textarea on content change
                // quill.on('text-change', function() {
                //     syncContent();
                // });

                // Ensure content is synced before form submission
                // const form = document.getElementById('create-email-template'); // Adjusted ID for edit page
                // form.addEventListener('submit', function(e) {
                //     syncContent();

                //     // Basic validation for Quill content
                //     const content = quill.getText().trim(); // Get plain text for validation
                //     if (content.length < 5) { // Adjusted minimum length
                //         e.preventDefault();
                //         alert('Please enter some content for the email body (at least 5 characters).');
                //         return false;
                //     }
                // });

                // Add custom CSS for the variable button (you could also put this in your main CSS file)
                const style = document.createElement('style');
                style.textContent = `
                    .ql-variable:before {
                        content: "Var";
                        font-weight: bold;
                        font-size: 11px;
                        color: #007bff; /* Or your preferred color */
                    }
                `;
                document.head.appendChild(style);

                // Focus on the first input when page loads
                // document.getElementById('name').focus();


                quill.root.innerHTML = document.querySelector('#body').value;

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
                    syncContent();
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
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    subject: {
                        required: true,
                        minlength: 5,
                        maxlength: 255,
                    },
                    variables: {
                        required: true,
                        pattern: /^[a-zA-Z0-9_,\s]+$/, // Allows alphanumeric, underscores, commas, and spaces
                    },
                    description: {
                        required: true,
                        minlength: 10,
                        maxlength: 500,
                    },
                };

                const messages = {
                    name: {
                        required: "Name is required",
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot exceed 100 characters",
                    },
                    subject: {
                        required: "Subject is required",
                        minlength: "Subject must be at least 5 characters",
                        maxlength: "Subject cannot exceed 255 characters",
                    },
                    variables: {
                        required: "Variables are required",
                        pattern: "Variables must be alphanumeric, underscores, commas, and spaces only",
                    },
                    description: {
                        required: "Description is required",
                        minlength: "Description must be at least 10 characters",
                        maxlength: "Description cannot exceed 500 characters",
                    },
                };

                $.validator.addMethod("pattern", function(value, element, param) {
                    if (this.optional(element)) {
                        return true;
                    }
                    return new RegExp(param).test(value);
                }, "Please check your input.");

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

                handleValidation("create-email-template", rules, messages);

                document.getElementById('create-email-template').addEventListener('submit', function(e) {
                    e.preventDefault();
                    validateText();
                    if (!hasError && $(this).valid()) {
                        document.getElementById("body").value = quill.root.innerHTML;
                        $('.save-all-btn').prop('disabled', true);
                        $('.overlay').css('display', 'block');
                        this.submit();
                    }
                });

            });
        </script>
    @endpush
</x-admin-layout>