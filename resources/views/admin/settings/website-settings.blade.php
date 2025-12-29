
<x-admin-layout>
    @section('title', 'Website Settings')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ env('APP_NAME') }}</a>
                        </li>
                        <li class="breadcrumb-item active">Website Settings
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">Website Settings</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <form action="{{ route('admin.settings.website.store') }}" method="POST"
                            enctype="multipart/form-data" id="website-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card card-body border-0 shadow mb-4 mt-4 error-div-box">
                                        <h2 class="h5 mb-4">Select Logo</h2>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="user-avatar xl-avatar">
                                                    <img class="rounded avatar-xl logo-image-preview"
                                                        src="{{ isset($logo) && $logo !== '' ? Storage::url($logo) : asset('assets/custom/images/default-category-image.webp') }}"
                                                        alt="Profile Photo">
                                                </div>
                                            </div>
                                            <div class="file-field">
                                                <div class="d-flex justify-content-xl-center ms-xl-3">
                                                    <div class="d-flex">
                                                        <span class="icon icon-md">
                                                            <svg class="icon text-gray-500 me-2" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                        <input type="file" name="logo" accept="image/*"
                                                            id="logo_image">
                                                        <div class="d-md-block text-left">
                                                            <div class="fw-normal text-dark mb-1">Choose Image</div>
                                                            <div class="text-gray small">JPG, JPEG or PNG. Max size of
                                                                2MB
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="d-none invalid-feedback fileTypeError">Image format is not
                                            valid</span>
                                        <span class="d-none invalid-feedback fileSizeError">Your image can't be more
                                            than 2
                                            MB</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card card-body border-0 shadow mb-4 mt-4 error-div-box">
                                        <h2 class="h5 mb-4">Select Favicon</h2>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="user-avatar xl-avatar">
                                                    <img class="rounded avatar-xl favicon-image-preview"
                                                        src="{{ isset($favicon) && $favicon !== '' ? Storage::url($favicon) : asset('assets/custom/images/default-category-image.webp') }}"
                                                        alt="Profile Photo">
                                                </div>
                                            </div>
                                            <div class="file-field">
                                                <div class="d-flex justify-content-xl-center ms-xl-3">
                                                    <div class="d-flex">
                                                        <span class="icon icon-md">
                                                            <svg class="icon text-gray-500 me-2" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                        <input type="file" name="favicon" accept="image/*"
                                                            id="favicon_image">
                                                        <div class="d-md-block text-left">
                                                            <div class="fw-normal text-dark mb-1">Choose Image</div>
                                                            <div class="text-gray small">JPG, JPEG or PNG. Max size of
                                                                2MB
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('favicon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="d-none invalid-feedback fileTypeError">Image format is not
                                            valid</span>
                                        <span class="d-none invalid-feedback fileSizeError">Your image can't be more
                                            than 2
                                            MB</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="website_name">Website Name</label>
                                        <input class="form-control @error('website_name') is-invalid @enderror"
                                            id="website_name" type="text" placeholder="Website name"
                                            name="website_name" value="{{ old('website_name', $website_name ?? '') }}">
                                        @error('website_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js') }}"></script>
        <script>
            jQuery(document).ready(function() {
                const rules = {
                    logo: {
                        required: true,
                    },
                    favicon: {
                        required: true,
                    },
                    website_name: {
                        required: true,
                        minlength: firstNametMinLength,
                        maxlength: firstNameMaxLength,
                    },

                }
                const messages = {
                    logo: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'logo']) }}`,
                    },
                    favicon: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'favicon']) }}`,
                    },
                     website_name: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'website name']) }}`,
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => 'website name', 'min' => '2']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'website name', 'max' => '50']) }}`,
                    },

                };

                handleValidation('website-form', rules, messages);

                let isValid = true;

                jQuery("#logo_image").change(function() {
                    isValid = checkFile(this);
                });

                jQuery("#favicon_image").change(function() {
                    isValid = checkFile(this);
                });

                $('#website-form').on('submit', function(event) {
                    if ($('#website-form').valid() && isValid) {
                        $('.save-all-btn').prop('disabled', true);
                        $('.overlay').css('display', 'block');
                    } else {
                        event.preventDefault();
                    }
                });

                function checkFile(input) {
                    const file = input.files[0];
                    if (file) {
                        const fileSize = file.size / 1024 / 1024; // in MB
                        const fileType = file.type;

                        const cardElement = $(input).closest('.error-div-box');

                        if (fileSize > 2) {
                            cardElement.find(".fileSizeError").removeClass('d-none');
                            cardElement.find(".fileTypeError").addClass('d-none');
                            input.value = "";
                            return false;
                        }

                        if (!["image/png", "image/jpg", "image/jpeg"].includes(fileType)) {
                            cardElement.find(".fileTypeError").removeClass('d-none');
                            cardElement.find(".fileSizeError").addClass('d-none');
                            input.value = "";
                            return false;
                        }

                        cardElement.find(".fileSizeError").addClass('d-none');
                        cardElement.find(".fileTypeError").addClass('d-none');

                        let reader = new FileReader();
                        reader.onload = function(event) {
                            if (input.id === "logo_image") {
                                jQuery(".logo-image-preview").attr("src", event.target.result);
                            }else if (input.id === "favicon_image") {
                                jQuery(".favicon-image-preview").attr("src", event.target.result);
                            }
                        };
                        reader.readAsDataURL(file);

                        return true;
                    }
                    return false;
                }

            });
        </script>
    @endpush
</x-admin-layout>
