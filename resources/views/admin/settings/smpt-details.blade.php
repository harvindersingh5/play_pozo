<x-admin-layout>
    @section('title', 'SMTP Details')
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
                        <li class="breadcrumb-item active">SMTP Details
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">SMTP Details</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card card-body shadow-sm mb-4">
                        <h5 class="card-title mb-3">SMTP Email Settings</h5>
                        <form action="{{ route('admin.settings.smpt_details.store') }}" method="POST"
                            id="smtp-settings-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="smtp_host">SMTP Host <span class="text-danger">*</span></label>
                                        <input class="form-control @error('smtp_host') is-invalid @enderror"
                                            id="smtp_host" type="text" placeholder="e.g. smtp.gmail.com"
                                            name="smtp_host" value="{{ old('smtp_host', $smtp_details['host'] ?? '') }}"
                                            required>
                                        @error('smtp_host')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="smtp_port">SMTP Port <span class="text-danger">*</span></label>
                                        <input class="form-control @error('smtp_port') is-invalid @enderror"
                                            id="smtp_port" type="number" placeholder="e.g. 587" name="smtp_port"
                                            value="{{ old('smtp_port', $smtp_details['port'] ?? '') }}" required>
                                        @error('smtp_port')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="smtp_username">SMTP Username <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('smtp_username') is-invalid @enderror"
                                            id="smtp_username" type="text" placeholder="your-email@domain.com"
                                            name="smtp_username"
                                            value="{{ old('smtp_username', $smtp_details['username'] ?? '') }}"
                                            required>
                                        @error('smtp_username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="smtp_password">SMTP Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </span>
                                            <input class="form-control @error('smtp_password') is-invalid @enderror"
                                                id="smtp_password" type="password" placeholder="Your SMTP password"
                                                name="smtp_password" value="{{ old('smtp_password', isset($smtp_details['password']) ? decrypt($smtp_details['password']) : '') }}" required>
                                        </div>
                                        @error('smtp_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        {{-- <small class="form-text text-muted">Leave blank to keep existing
                                            password</small> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="smtp_encryption">Encryption Type</label>
                                        <select class="form-control @error('smtp_encryption') is-invalid @enderror"
                                            id="smtp_encryption" name="smtp_encryption">
                                            <option value="">None</option>
                                            <option value="tls"
                                                {{ old('smtp_encryption', $smtp_details['encryption'] ?? '') == 'tls' ? 'selected' : '' }}>
                                                TLS</option>
                                            <option value="ssl"
                                                {{ old('smtp_encryption', $smtp_details['encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>
                                                SSL</option>
                                        </select>
                                        @error('smtp_encryption')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="mail_from_address">From Email Address <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('mail_from_address') is-invalid @enderror"
                                            id="mail_from_address" type="email" placeholder="noreply@domain.com"
                                            name="mail_from_address"
                                            value="{{ old('mail_from_address', $smtp_details['from_address'] ?? '') }}"
                                            required>
                                        @error('mail_from_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="mail_from_name">From Name <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control @error('mail_from_name') is-invalid @enderror"
                                            id="mail_from_name" type="text" placeholder="Your Website Name"
                                            name="mail_from_name"
                                            value="{{ old('mail_from_name', $smtp_details['from_name'] ?? '') }}"
                                            required>
                                        @error('mail_from_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">
                                    Save
                                </button>
                                {{-- <button type="button" class="btn btn-secondary mt-2 ms-2" id="resetForm">
                                    <i class="fas fa-undo"></i> Reset
                                </button> --}}
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
                    smtp_host: {
                        required: true,
                        // pattern: /^(?!:\/\/)([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/, // Uncomment if you have a regex for hostnames
                        minlength: 3,
                        maxlength: 50,
                    },
                    smtp_port: {
                        required: true,
                        min: 1,
                        max: 65535,
                    },
                    smtp_username: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                    },
                    smtp_password: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                    },
                    smtp_encryption: {
                        required: true,
                    },
                    mail_from_address: {
                        email: true,
                        maxlength: emailMaxLength,
                        regex: emailRegex,
                    },
                    mail_from_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                    },
                };
                const messages = {
                    smtp_host: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'SMTP host']) }}`,
                        // pattern: 'Please enter a valid SMTP host (e.g., smtp.example.com).', // Uncomment if using pattern
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => 'SMTP host', 'min' => '3']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'SMTP host', 'max' => '50']) }}`,
                    },
                    smtp_port: {
                        required: 'SMTP port is required.',
                        min: 'SMTP port must be at least 1.',
                        max: 'SMTP port cannot exceed 65535.',
                    },
                    smtp_username: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'SMTP username']) }}`,
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => 'SMTP username', 'min' => '3']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'SMTP username', 'max' => '50']) }}`,
                    },
                    smtp_password: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'SMTP password']) }}`,
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => 'SMTP password', 'min' => '3']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'SMTP password', 'max' => '50']) }}`,
                    },
                    smtp_encryption: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'SMTP encryption type']) }}`,
                    },
                    mail_from_address: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                        email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                        regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'email', 'max' => '254']) }}`,
                    },
                    mail_from_name: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => '"From" name']) }}`,
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => '"From" name', 'min' => '3']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => '"From" name', 'max' => '50']) }}`,
                    },
                };

                handleValidation('smtp-settings-form', rules, messages);

                $('#smtp-settings-form').on('submit', function(event) {
                    if ($('#smtp-settings-form').valid()) {
                        $('.save-all-btn').prop('disabled', true);
                        $('.overlay').css('display', 'block');
                    } else {
                        event.preventDefault();
                    }
                });

                // Reset Form
                $("#resetForm").on('click', function() {
                    if (confirm("Are you sure you want to reset all SMTP settings?")) {
                        $("#smtp-settings-form").reset();
                    }
                });

            });
        </script>
    @endpush
</x-admin-layout>
