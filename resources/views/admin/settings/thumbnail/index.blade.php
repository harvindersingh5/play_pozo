<x-admin-layout>
    @section('title', 'Thumbnail Sizes')
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
                    <li class="breadcrumb-item active" aria-current="page">Thumbnail Sizes</li>
                </ol>
            </nav>
            <h2 class="h4">Thumbnail Sizes</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.settings.thumbnail.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                New Size
            </a>
        </div>
    </div>
    @include('admin.common.notification')
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            {{-- <form id="userFilterForm"> --}}
            <x-common-search-form />
            {{-- </form> --}}
            <div class="col-3 col-lg-4 d-flex justify-content-end">
                <div class="btn-group">
                    <div class="dropdown me-1">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z">
                                </path>
                            </svg>
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pb-0">
                            <span class="small ps-3 fw-bold text-dark">Show</span>
                            <a class="dropdown-item d-flex align-items-center fw-bold pagination-number custom-check-pagination"
                                data-paginationNumber="10" href="javascript:;">10 <svg class="icon icon-xxs ms-auto"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg></a>
                            <a class="dropdown-item fw-bold pagination-number" data-paginationNumber="20"
                                href="javascript:;">20</a>
                            <a class="dropdown-item fw-bold rounded-bottom pagination-number" data-paginationNumber="30"
                                href="javascript:;">30</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 row">
            <div class="d-flex align-items-center mb-3 mb-md-0 col-md-6">
                <span class="h5 fw-normal me-3">
                    Convert to WebP,
                    No
                </span>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="convertWebpSwitch" name="convert_to_webp"
                        value="true" {{ old('convert_to_webp', $convertToWebp ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="convertWebpSwitch"></label>
                </div>
                <span class="h5 fw-normal ms-3">
                    Yes
                </span>
            </div>
            <div class="d-flex align-items-center col-md-6">
                <span class="h5 fw-normal me-3">
                    WebP Conversion Quality:
                </span>
                <div class="form-group">
                    <select id="webp_quality" name="webp_quality" class="form-select" style="width: 150%;">
                        <option value="100" @selected(old('webp_quality', $webpQuality ?? 80) == '100')>100% (Lossless)</option>
                        <option value="95" @selected(old('webp_quality', $webpQuality ?? 80) == '95')>95% (Very High)</option>
                        <option value="90" @selected(old('webp_quality', $webpQuality ?? 80) == '90')>90% (High)</option>
                        <option value="85" @selected(old('webp_quality', $webpQuality ?? 80) == '85')>85% (Good)</option>
                        <option value="80" @selected(old('webp_quality', $webpQuality ?? 80) == '80')>80% (Recommended)</option>
                        <option value="75" @selected(old('webp_quality', $webpQuality ?? 80) == '75')>75% (Medium)</option>
                        <option value="70" @selected(old('webp_quality', $webpQuality ?? 80) == '70')>70% (Lower)</option>
                    </select>
                    {{-- <p class="text-xs text-gray-500 mt-2">
                Lower quality values result in smaller file sizes but may reduce image clarity.
                Recommended: 80%.
            </p> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="userList">
                <x-settings-list :settings="$settings" />
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function() {
                const convertWebpSwitch = document.getElementById('convertWebpSwitch');

                $("#convertWebpSwitch").on('change', function() {
                    const isChecked = this.checked;
                    const convertWebpValue = isChecked ? true : false;

                    fetch('{{ route('admin.settings.image-conversion.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                convert_to_webp: convertWebpValue
                            })
                        })
                        .then(response => {
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.indexOf('application/json') !== -1) {
                                return response.json();
                            } else {
                                throw new Error('Server response was not JSON. Status: ' + response.status);
                            }

                        })
                        .then(data => {
                            if (data.status) {
                                toastMsg('success', data.message, '#262B40');
                            } else {
                                console.error('Error:', data.message);
                                toastMsg('error', data.message, '#FA5252');
                                this.checked = !isChecked;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.checked = !isChecked;
                            toastMsg('error', 'Failed to update WebP conversion setting.', '#FA5252');
                        });
                });

                $("#webp_quality").on('change', function() {
                    const webpQuality = $(this).val();

                    fetch('{{ route('admin.settings.webp-quality.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                webp_quality: webpQuality
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                toastMsg('success', data.message, '#262B40');
                            } else {
                                console.error('Error:', data.message);
                                toastMsg('error', data.message, '#FA5252');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastMsg('error', 'Failed to update WebP quality setting.', '#FA5252');
                        });
                });
            });
        </script>
    @endpush
</x-admin-layout>
