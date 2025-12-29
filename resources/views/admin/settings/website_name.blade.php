<x-admin-layout>
    @section('title', 'Website Name')
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
                        <li class="breadcrumb-item active">Website Name
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">Website Name</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.settings.website_name.store') }}" method="POST"
                        id="website-name-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="website_name">Website Name</label>
                                    <input class="form-control @error('website_name') is-invalid @enderror"
                                        id="website_name" type="text" placeholder="Website name" name="website_name"
                                        value="{{ old('website_name', $website_name ?? '') }}">
                                    @error('website_name')
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
        <script>
            jQuery(document).ready(function() {
                const rules = {
                    website_name: {
                        required: true,
                        minlength: firstNametMinLength,
                        maxlength: firstNameMaxLength,
                    },

                }
                const messages = {
                    website_name: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'website name']) }}`,
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => 'website name', 'min' => '2']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'website name', 'max' => '50']) }}`,
                    },

                };

                handleValidation('website-name-form', rules, messages);

                $('#website-name-form').on('submit', function(event) {
                    if ($('#website-name-form').valid()) {
                        $('.save-all-btn').prop('disabled', true);
                        $('.overlay').css('display', 'block');
                    } else {
                        event.preventDefault();
                    }
                });

            });
        </script>
    @endpush
</x-admin-layout>
