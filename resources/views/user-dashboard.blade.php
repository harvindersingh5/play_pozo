<x-auth-layout>
    @section('title', 'User Dashboard')
    @php
        $user = auth()->user();
    @endphp
    @include('admin.common.notification')
    <section class="vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center d-flex align-items-center justify-content-center">
                    <div>
                        <h3>Website Logo</h3>
                        <img class="img-fluid"
                            src="{{ \App\Models\Setting::getSetting('logo') ? Storage::url(\App\Models\Setting::getSetting('logo')) : asset('assets/img/illustrations/404.svg') }}"
                            width="234" height="143" alt="404 not found">
                        <p>Website Name: <i>{{ \App\Models\Setting::getSetting('website_name') ?? env('APP_NAME') }}
                            </i> </p>
                        <h1 class="mt-5">User <span class="fw-bolder text-primary">Dashboard</span></h1>
                        <p class="lead my-4">Hi, {{ auth()->check() ? auth()->user()->full_name : '' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="btn btn-gray-800 d-inline-flex align-items-center justify-content-center mb-4">
                                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center d-flex align-items-center justify-content-center">
                    <div class="error-div-box">
                        <h3>Profile Pic</h3>
                        <img src="{{ auth()->user()->profile_url }}" class="cursor-pointer" id="profile-image-preview"
                            style="height: 150px; width: 150px; border-radius:50%; border:2px solid black;"
                            alt="Profile image">
                        <input type="file" name="profile_pic" id="profile_pic" accept="image/*" hidden>
                        <span class="d-none invalid-feedback fileTypeError">Image format is not valid</span>
                                <span class="d-none invalid-feedback fileSizeError">Your image can't be more than 2
                                    MB</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Profile Thumbnails</h3>
                    <div id="thumbnailsContainer"
                        class="thumbnails-preview d-flex flex-wrap justify-content-center align-items-center gap-3">
                        {{-- @foreach ($user->Thumbnails as $thumbnail)
                            <img src="{{ Storage::url($thumbnail->url) }}" class="thumbnail-item cursor-pointer"
                                alt="Profile image">
                        @endforeach --}}
                        @include('partials.profile_thumbnails', ['thumbnails' => $user->thumbnails])
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#profile-image-preview').on('click', function() {
                    $('#profile_pic').trigger('click');
                });
                $('#profile_pic').on('change', function() {
                    var file = this.files[0];

                    if (checkFile(this)) {
                        var formData = new FormData();
                        formData.append('profile_pic', file);

                        var url = '{{ route('update-profile-pic') }}';

                        let response = ajaxCall(url, 'post', formData);
                        response.then((response) => {
                            if (response.status == true) {
                                toastMsg('success', response.message, '#262B40');
                                if (response.thumbnails_html) {
                                    const thumbnailsContainer = $("#thumbnailsContainer");
                                    thumbnailsContainer.html(response.thumbnails_html);
                                }
                            } else {
                                console.log('error', response.message);
                            }
                        }).catch((error) => {
                            console.error('Ajax call failed:', error);
                        });
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
                            if (input.id === "profile_pic") {
                                jQuery("#profile-image-preview").attr("src", event.target.result);
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
</x-auth-layout>
