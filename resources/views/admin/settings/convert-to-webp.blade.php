<x-admin-layout>
    @section('title', 'Image Conversion Settings')
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
                        <li class="breadcrumb-item active">Image Conversion Settings
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">Image Conversion Settings</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.settings.image-conversion.store') }}" method="POST"
                        id="image-conversion-settings-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="convert_to_webp">
                                    Convert Images to WebP Format?
                                </label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div
                                            class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200 w-full sm:w-1/2">
                                            <input type="radio" id="convert_to_webp_true" name="convert_to_webp"
                                                value="true"
                                                class="form-check-input h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 rounded-full"
                                                @checked(old('convert_to_webp', $convertToWebp ?? false) == 'true')>
                                            <label for="convert_to_webp_true"
                                                class="ml-3 text-sm font-medium text-gray-700 cursor-pointer ">
                                                Yes, Convert to WebP
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div
                                            class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200 w-full sm:w-1/2">
                                            <input type="radio" id="convert_to_webp_false" name="convert_to_webp"
                                                value="false"
                                                class="form-check-input h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 rounded-full"
                                                @checked(old('convert_to_webp', $convertToWebp ?? false) == 'false')>
                                            <label for="convert_to_webp_false"
                                                class="ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                                                No, Do Not Convert
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    Enabling WebP conversion can improve website performance by reducing image file
                                    sizes.
                                </p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js') }}"></script>
    @endpush
</x-admin-layout>
