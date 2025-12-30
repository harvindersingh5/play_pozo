<x-admin-layout>
    @section('title', 'User Details')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show user</li>
                    </ol>
                </nav>
                <h2 class="h4">Show user</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body shadow-sm mb-4">
                    <h2 class="h5 mb-4">General information</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="first_name">First Name</label>
                                <input class="form-control" id="first_name" type="text"
                                    placeholder="Enter your first name" name="first_name"
                                    value="{{ $user->first_name ?? 'N/A' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div>
                                <label for="last_name">Last Name</label>
                                <input class="form-control " id="last_name" type="text"
                                    placeholder="Also your last name" name="last_name"
                                    value="{{ $user->last_name ?? 'N/A' }}" disabled>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control " id="email" type="email"
                                    placeholder="user@yopmail.com" name="email" value="{{ @$user->email ?? 'N/A' }}"
                                    disabled>

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender">Gender</label>
                            <input class="form-control " id="gender" type="text"
                                value="{{ @$user->user_detail->gender }}"disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <input class="form-control " id="status" type="text" name="status"
                                value="{{ $user->status }}"disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role">Role</label>
                            <input class="form-control " id="role" type="text" name="role"
                                value="{{ $user->getRoleNames()[0] ?? 'N/A' }}" disabled>
                        </div>
                    </div>
                    <h2 class="h5 my-4">Location</h2>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input class="form-control" id="address" type="text"
                                    placeholder="Enter your home address" name="address"
                                    value="{{ @$user->user_detail->address }}" disabled>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="Country">Country</label>
                                <input class="form-control" id="Country" type="text" placeholder="Country"
                                    name="country" value="{{ @$user->user_detail->country }}" disabled>

                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="state">state</label>
                                <input class="form-control" id="state" type="text" placeholder="state"
                                    name="state" value="{{ @$user->user_detail->state }}" disabled>

                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-group">
                                <label for="city">city</label>
                                <input class="form-control " id="city" type="text" placeholder="city"
                                    name="city" value="{{ @$user->user_detail->city }}" disabled>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="postal_code">Zip code</label>
                                <input class="form-control" id="postal_code" type="tel" placeholder="Zip"
                                    name="postal_code" value="{{ @$user->user_detail->pincode }}" disabled>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input class="form-control " id="phone_number" type="text"
                                    placeholder="+12-345 678 910" name="phone_number"
                                    value="{{ @$user->user_detail->phone_number ?? 'N/A' }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 text-center p-0">
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
                        <div class="card card-body border-0 shadow mb-4 mt-4">
                            <h2 class="h5 mb-4">Profile photo</h2>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <!-- Avatar -->
                                    <div class="user-avatar xl-avatar">
                                        <img class="rounded avatar-xl preview-image"
                                            src="{{ $user->profile_url }}"
                                            alt="Profile Picture">
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="card card-body border-0 shadow mb-4 mt-4 error-div-box">
                            <h2 class="h5 mb-4">Background photo</h2>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="user-avatar xl-avatar">
                                        <img class="rounded avatar-xl back-preview-image"
                                            src="{{ $user->background_url }}"
                                            alt="Background Photo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
