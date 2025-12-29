<x-admin-layout>
    @section('title', 'WebP Quality')
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
                        <li class="breadcrumb-item active">WebP Quality
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">WebP Quality</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.settings.webp-quality.store') }}" method="POST" id="webp-quality-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="webp_quality">
                                        WebP Conversion Quality:
                                    </label>
                                    <select id="webp_quality" name="webp_quality"
                                        class="form-select block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('webp_quality') is-invalid @enderror">
                                        <option value="100" @selected(old('webp_quality', $webpQuality ?? 80) == '100')>100% (Lossless)</option>
                                        <option value="95" @selected(old('webp_quality', $webpQuality ?? 80) == '95')>95% (Very High)</option>
                                        <option value="90" @selected(old('webp_quality', $webpQuality ?? 80) == '90')>90% (High)</option>
                                        <option value="85" @selected(old('webp_quality', $webpQuality ?? 80) == '85')>85% (Good)</option>
                                        <option value="80" @selected(old('webp_quality', $webpQuality ?? 80) == '80')>80% (Recommended)</option>
                                        <option value="75" @selected(old('webp_quality', $webpQuality ?? 80) == '75')>75% (Medium)</option>
                                        <option value="70" @selected(old('webp_quality', $webpQuality ?? 80) == '70')>70% (Lower)</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-2">
                                        Lower quality values result in smaller file sizes but may reduce image clarity.
                                        Recommended: 80%.
                                    </p>
                                    @error('webp_quality')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
