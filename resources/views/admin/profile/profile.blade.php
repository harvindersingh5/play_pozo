<x-admin-layout>
    @section('title', 'Profile')
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
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ config('app.name') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
                <h2 class="h4">Profile</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <form action="{{ route('admin.update-profile') }}" method="POST" id="update-admin-profile"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="first_name">First Name</label>
                                    <input class="form-control @error('first_name') is-invalid @enderror"
                                        id="first_name" type="text" placeholder="Enter your first name"
                                        name="first_name" value="{{ old('first_name', $user->first_name) }}">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="last_name">Last Name</label>
                                    <input class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                        type="text" placeholder="Also your last name" name="last_name"
                                        value="{{ old('last_name', $user->last_name) }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        type="email" placeholder="user@yopmail.com" name="email"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-select mb-0 @error('gender') is-invalid @enderror"
                                        id="gender" aria-label="Gender select example" name="gender">
                                        <option value="" selected>Select gender</option>
                                        <option value="Male" @if (@$user->user_detail->gender == 'Male') selected @endif>Male
                                        </option>
                                        <option value="Female" @if (@$user->user_detail->gender == 'Female') selected @endif>Female
                                        </option>
                                        <option value="Other" @if (@$user->user_detail->gender == 'Other') selected @endif>Other
                                        </option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h2 class="h5 my-4">Location</h2>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input class="form-control @error('address') is-invalid @enderror" id="address"
                                        type="text" placeholder="Enter your home address" name="address"
                                        value="{{ old('address', @$user->user_detail->address) }}">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <div class="form-group">
                                    <label for="Country">Country</label>
                                    {{-- <input class="form-control  @error('country') is-invalid @enderror" id="Country"
                                        type="text" placeholder="Country" name="country"
                                        value="{{ old('country', @$user->user_detail->country) }}"> --}}
                                    <select id="country" name="country" class="form-select form-control mb-0"
                                        data-selected="{{ @$user->user_detail->country ?? '' }}">
                                        <option value="">Select Country</option>
                                    </select>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    {{-- <input class="form-control @error('state') is-invalid @enderror" id="state"
                                        type="text" placeholder="State" name="state"
                                        value="{{ old('state', @$user->user_detail->state) }}"> --}}
                                    <select id="state" name="state" class="form-select form-control mb-0"
                                        data-selected="{{ @$user->user_detail->state ?? '' }}">
                                        <option value="">Select State</option>
                                    </select>
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    {{-- <input class="form-control @error('city') is-invalid @enderror" id="city"
                                        type="text" placeholder="City" name="city"
                                        value="{{ old('city', @$user->user_detail->city) }}"> --}}
                                    <select id="city" name="city" class="form-select form-control mb-0"
                                        data-selected="{{ @$user->user_detail->city ?? '' }}">
                                        <option value="">Select City</option>
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="postal_code">Zip code</label>
                                    <input class="form-control  @error('postal_code') is-invalid @enderror"
                                        id="postal_code" type="tel" placeholder="Zip" name="postal_code"
                                        value="{{ old('postal_code', @$user->user_detail->pincode) }}">
                                    @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input class="form-control  @error('phone_number') is-invalid @enderror"
                                        id="phone_number" type="text" placeholder="+12-345 678 910"
                                        name="phone_number"
                                        value="{{ old('phone_number', @$user->user_detail->phone_number) }}">
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 update-profile">Save
                                All</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 text-center p-0 user-profile-box">
                            <div class="profile-cover rounded-top back-preview-image"
                                data-background="{{ $user->background_url }}"
                                style="background: url(&quot;../assets/img/profile-cover.jpg&quot;);">
                            </div>
                            <div class="card-body pb-5">
                                <img src="{{ $user->profile_url }}"
                                    class="avatar-xl rounded-circle mx-auto mt-n7 mb-4 front-preview-image"
                                    alt="Profile Preview">
                                <h4 class="h3">{{ $user->first_name }} {{ $user->last_name }}</h4>
                                <h5 class="fw-normal">{{ $user->getRoleNames()[0] ?? 'N/A' }}</h5>
                                <p class="text-gray mb-4">
                                    {{ @$user->user_detail?->city_name }},{{ @$user->user_detail?->country_name }}</p>
                                {{-- <a class="btn btn-sm btn-gray-800 d-inline-flex align-items-center me-2"
                                    href="#">
                                    <svg class="icon icon-xs me-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z">
                                        </path>
                                    </svg>
                                    Connect
                                </a>
                                <a class="btn btn-sm btn-secondary" href="#">Send Message</a> --}}
                            </div>
                        </div>
                        <div class="card card-body border-0 shadow mb-4 mt-4 error-div-box">
                            <h2 class="h5 mb-4">Edit profile photo</h2>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <!-- Profile Image Preview -->
                                    <div class="user-avatar xl-avatar">
                                        {{-- <img class="rounded avatar-xl front-preview-image"
                                            src="{{ $user && $user->user_detail && $user->user_detail->profile_path ? $user->user_detail->public_url : asset('assets/img/team/profile-picture-1.jpg') }}"
                                            alt="Profile Photo"> --}}
                                        <img class="rounded avatar-xl front-preview-image"
                                            src="{{ $user->profile_url }}" alt="Profile Photo">
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
                                            <input type="file" name="profile_picture" form="update-admin-profile"
                                                accept="image/*" id="profilePic">
                                            <div class="d-md-block text-left">
                                                <div class="fw-normal text-dark mb-1">Choose Image</div>
                                                <div class="text-gray small">JPG, JPEG or PNG. Max size of 2MB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('profile_picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="d-none invalid-feedback fileTypeError">Image format is not valid</span>
                            <span class="d-none invalid-feedback fileSizeError">Your image can't be more than 2
                                MB</span>
                        </div>
                        <div class="card card-body border-0 shadow mb-4 mt-4 error-div-box">
                            <h2 class="h5 mb-4">Edit background photo</h2>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <!-- Background Image Preview -->
                                    {{-- @dd($user->user_detail->back_profile_path,$user->user_detail->background_url); --}}
                                    <div class="user-avatar xl-avatar">
                                        {{-- <img class="rounded avatar-xl back-preview-image"
                                            src="{{ $user && $user->user_detail && $user->user_detail->back_profile_path ? $user->user_detail->background_url : asset('assets/img/team/profile-picture-1.jpg') }}"
                                            alt="Background Photo"> --}}
                                        <img class="rounded avatar-xl back-preview-image"
                                            src="{{ $user->background_url }}" alt="Background Photo">
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
                                            <input type="file" name="back_picture" form="update-admin-profile"
                                                accept="image/*" id="backgroundProfilepic">
                                            <div class="d-md-block text-left">
                                                <div class="fw-normal text-dark mb-1">Choose Image</div>
                                                <div class="text-gray small">JPG, JPEG or PNG. Max size of 2MB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('back_picture')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="d-none invalid-feedback fileTypeError">Image format is not valid</span>
                            <span class="d-none invalid-feedback fileSizeError">Your image can't be more than 2
                                MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js') }}"></script>
        @include('validation.admin_profile')
        @include('admin.partials.country-state-city-dropdown-js')
        <script>
            $(document).ready(function() {
                let isValid = true;

                jQuery("#profilePic, #backgroundProfilepic").change(function() {
                    isValid = checkFile(this);
                });

                $('#update-admin-profile').on('submit', function(event) {
                    if ($('#update-admin-profile').valid() && isValid) {
                        $('.update-profile').prop('disabled', true);
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

                        const errorBox = $(input).closest('.error-div-box');

                        if (fileSize > 2) {
                            errorBox.find(".fileSizeError").removeClass('d-none');
                            errorBox.find(".fileTypeError").addClass('d-none');
                            input.value = "";
                            return false;
                        }

                        if (!["image/png", "image/jpg", "image/jpeg"].includes(fileType)) {
                            errorBox.find(".fileTypeError").removeClass('d-none');
                            errorBox.find(".fileSizeError").addClass('d-none');
                            input.value = "";
                            return false;
                        }

                        errorBox.find(".fileSizeError").addClass('d-none');
                        errorBox.find(".fileTypeError").addClass('d-none');

                        let reader = new FileReader();
                        reader.onload = function(event) {
                            if (input.id === "profilePic") {
                                jQuery(".front-preview-image").attr("src", event.target.result);
                            } else if (input.id === "backgroundProfilepic") {
                                jQuery(".back-preview-image").attr("src", event.target.result);
                                jQuery('.back-preview-image').attr('data-background', event.target.result);
                                jQuery('.back-preview-image').css('background', 'url(' + event.target.result + ')');
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
