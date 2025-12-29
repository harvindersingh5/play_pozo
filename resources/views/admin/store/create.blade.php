<x-admin-layout>
    @section('title', 'Create Category')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Stores List</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Store</li>
                    </ol>
                </nav>
                <h2 class="h4">Add Store</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.store.store') }}" method="POST" id="store-create"
                        enctype="multipart/form-data">
                        {{-- <input type="hidden" name="profile_picture" id="Profile" value=""> --}}
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="store_name">Store Name</label>
                                    <input class="form-control @error('store_name') is-invalid @enderror" id="store_name"
                                        type="text" placeholder="Name" name="store_name" value="{{ old('store_name') }}">
                                    @error('store_name')
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
                                    <label for="parent_id">Vender</label>
                                    <select
                                        class="form-select form-control mb-0 @error('parent_id') is-invalid @enderror"
                                        id="vendore_id" name="vendore_id">
                                        <option value="">Select vendore</option>
                                        @foreach ($vendores as $vendore)
                                            <option value="{{ $vendore->id }}"
                                                {{ old('parent_id') == $vendore->id ? 'selected' : '' }}>
                                                {{ ucwords($vendore->first_name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('vendore_id')
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
                                    <label for="name">Location</label>
                                    <input class="form-control @error('location') is-invalid @enderror" id="location"
                                        type="text" placeholder="Location" name="location" value="{{ old('location') }}">
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Save</button>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 p-0">
                            <img class="profile-cover rounded-top category-preview-image"
                                src="{{ asset('assets/custom/images/default-category-image.webp') }}">
                            <div class="card-body pb-5 error-div-box">
                                <h2 class="h5 mb-4">Select Store Image</h2>
                                <div class="me-3">
                                    <div class="file-field">
                                        <div class="d-flex justify-content-xl-center ms-xl-3">
                                            <div class="d-flex">
                                                <span class="icon icon-md"><svg class="icon text-gray-500 me-2"
                                                        fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                                <input type="file" name="store_image" form="create-category"
                                                    accept="image/*" id="store_image">
                                                <div class="d-md-block text-left">
                                                    <div class="fw-normal text-dark mb-1">Choose Image</div>
                                                    <div class="text-gray small">
                                                        JPG, GIF or PNG. Max size of 2MB</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('store_image')
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
    </div>
    </section>
    @push('scripts')
        @include('validation.store')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js') }}"></script>
    @endpush
</x-admin-layout>
