<x-admin-layout>
    @section('title', 'Add Stripe Details')

    {{-- <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
                                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ env('APP_NAME') }}</a></li>
                         <li class="breadcrumb-item"><a href="{{ route('admin.payment-settings.index') }}">Payment Settings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Stripe Details</li>
                    </ol>
                </nav>
                <h2 class="h4">Add Stripe Details</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body shadow-sm mb-4">
                    <form method="POST" action="{{ route('admin.payment-settings.store') }}" id="payment-settings">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="publicKey">Publishable Key<span class="form-star">*</span></label>
                                    <div class="input-group form-feild">
                                        <input type="text" name="public_key" id="publicKey"
                                            class="form-control @error('public_key') is-invalid @enderror"
                                            placeholder="********" value="{{ old('public_key') }}">
                                        <span class="input-group-text">
                                            <svg width="17" height="9" viewBox="0 0 17 9" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.00227 3C8.36477 1.2525 6.65318 0 4.63636 0C2.07477 0 0 2.01375 0 4.5C0 6.98625 2.07477 9 4.63636 9C6.65318 9 8.36477 7.7475 9.00227 6H12.3636V9H15.4545V6H17V3H9.00227ZM4.63636 6C3.7825 6 3.09091 5.32875 3.09091 4.5C3.09091 3.67125 3.7825 3 4.63636 3C5.49023 3 6.18182 3.67125 6.18182 4.5C6.18182 5.32875 5.49023 6 4.63636 6Z"
                                                    fill="#ACACAC" />
                                            </svg>
                                        </span>
                                    </div>
                                    @error('public_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="secretKey">Secret Key<span class="form-star">*</span></label>
                                    <div class="input-group form-feild">
                                        <input type="text" name="secret_key" id="secretKey"
                                            class="form-control @error('secret_key') is-invalid @enderror"
                                            placeholder="********" value="{{ old('secret_key') }}">
                                        <span class="input-group-text">
                                            <svg width="17" height="9" viewBox="0 0 17 9" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.00227 3C8.36477 1.2525 6.65318 0 4.63636 0C2.07477 0 0 2.01375 0 4.5C0 6.98625 2.07477 9 4.63636 9C6.65318 9 8.36477 7.7475 9.00227 6H12.3636V9H15.4545V6H17V3H9.00227ZM4.63636 6C3.7825 6 3.09091 5.32875 3.09091 4.5C3.09091 3.67125 3.7825 3 4.63636 3C5.49023 3 6.18182 3.67125 6.18182 4.5C6.18182 5.32875 5.49023 6 4.63636 6Z"
                                                    fill="#ACACAC" />
                                            </svg>
                                        </span>
                                    </div>
                                    @error('secret_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <p style="color: #b6b6b6;">You need to Check your keys first before submit</p>
                        <button type="button" class="btn btn-info check-api-keys">Check</button>
                        <button type="submit" class="btn btn-primary confirm-button" disabled>Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.payment-settings.index') }}">Payment
                                Settings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Payment Details</li>
                    </ol>
                </nav>
                <h2 class="h4">Add Payment Details</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card card-body shadow-sm mb-4">
                    <form method="POST" action="{{ route('admin.payment-settings.store') }}"
                        id="payment-settings-form">
                        @csrf

                        <ul class="nav nav-tabs" id="paymentMethodTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="stripe-tab" data-bs-toggle="tab"
                                    data-bs-target="#stripe-panel" type="button" role="tab"
                                    aria-controls="stripe-panel" aria-selected="true">Stripe</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="paypal-tab" data-bs-toggle="tab"
                                    data-bs-target="#paypal-panel" type="button" role="tab"
                                    aria-controls="paypal-panel" aria-selected="false">PayPal</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="paymentMethodTabContent">
                            <div class="tab-pane fade show active" id="stripe-panel" role="tabpanel"
                                aria-labelledby="stripe-tab">
                                <div class="mt-4">
                                    <h3>Stripe API Keys</h3>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div>
                                                <label for="stripe_public_key">Publishable Key<span
                                                        class="form-star">*</span></label>
                                                <div class="input-group form-feild">
                                                    <input type="text" name="public_key" id="stripe_public_key"
                                                        class="form-control @error('public_key') is-invalid @enderror"
                                                        placeholder="Stripe Publishable Key"
                                                        value="{{ old('public_key') }}">
                                                    <span class="input-group-text">
                                                        <svg width="17" height="9" viewBox="0 0 17 9"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.00227 3C8.36477 1.2525 6.65318 0 4.63636 0C2.07477 0 0 2.01375 0 4.5C0 6.98625 2.07477 9 4.63636 9C6.65318 9 8.36477 7.7475 9.00227 6H12.3636V9H15.4545V6H17V3H9.00227ZM4.63636 6C3.7825 6 3.09091 5.32875 3.09091 4.5C3.09091 3.67125 3.7825 3 4.63636 3C5.49023 3 6.18182 3.67125 6.18182 4.5C6.18182 5.32875 5.49023 6 4.63636 6Z"
                                                                fill="#ACACAC" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                @error('public_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div>
                                                <label for="stripe_secret_key">Secret Key<span
                                                        class="form-star">*</span></label>
                                                <div class="input-group form-feild">
                                                    <input type="text" name="secret_key" id="stripe_secret_key"
                                                        class="form-control @error('secret_key') is-invalid @enderror"
                                                        placeholder="Stripe Secret Key"
                                                        value="{{ old('secret_key') }}">
                                                    <span class="input-group-text">
                                                        <svg width="17" height="9" viewBox="0 0 17 9"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.00227 3C8.36477 1.2525 6.65318 0 4.63636 0C2.07477 0 0 2.01375 0 4.5C0 6.98625 2.07477 9 4.63636 9C6.65318 9 8.36477 7.7475 9.00227 6H12.3636V9H15.4545V6H17V3H9.00227ZM4.63636 6C3.7825 6 3.09091 5.32875 3.09091 4.5C3.09091 3.67125 3.7825 3 4.63636 3C5.49023 3 6.18182 3.67125 6.18182 4.5C6.18182 5.32875 5.49023 6 4.63636 6Z"
                                                                fill="#ACACAC" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                @error('secret_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted">You need to Check your Stripe keys first before submitting.
                                </p>
                                <button type="button" class="btn btn-info check-api-keys"
                                    data-gateway="stripe">Check</button>
                                <button type="submit" class="btn btn-primary confirm-button" disabled>Submit</button>
                                <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                            <div class="tab-pane fade" id="paypal-panel" role="tabpanel"
                                aria-labelledby="paypal-tab">
                                <div class="mt-4">
                                    <h3>PayPal API Keys</h3>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div>
                                                <label for="paypal_client_id">PayPal Client ID<span
                                                        class="form-star">*</span></label>
                                                <div class="input-group form-feild">
                                                    <input type="text" name="paypal_client_id"
                                                        id="paypal_client_id"
                                                        class="form-control @error('paypal_client_id') is-invalid @enderror"
                                                        placeholder="PayPal Client ID"
                                                        value="{{ old('paypal_client_id') }}">
                                                    <span class="input-group-text">
                                                        {{-- You can put a PayPal icon here if you have one --}}
                                                        <i class="fab fa-paypal"></i> {{-- Example using Font Awesome --}}
                                                    </span>
                                                </div>
                                                @error('paypal_client_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div>
                                                <label for="paypal_client_secret">PayPal Client Secret<span
                                                        class="form-star">*</span></label>
                                                <div class="input-group form-feild">
                                                    <input type="text" name="paypal_client_secret"
                                                        id="paypal_client_secret"
                                                        class="form-control @error('paypal_client_secret') is-invalid @enderror"
                                                        placeholder="PayPal Client Secret"
                                                        value="{{ old('paypal_client_secret') }}">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-lock"></i> {{-- Example using Font Awesome --}}
                                                    </span>
                                                </div>
                                                @error('paypal_client_secret')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div>
                                                <label for="paypal_mode">PayPal Mode</label>
                                                <select name="paypal_mode" id="paypal_mode"
                                                    class="form-control @error('paypal_mode') is-invalid @enderror">
                                                    <option value="sandbox"
                                                        {{ old('paypal_mode') == 'sandbox' ? 'selected' : '' }}>
                                                        Sandbox</option>
                                                    <option value="live"
                                                        {{ old('paypal_mode') == 'live' ? 'selected' : '' }}>
                                                        Live</option>
                                                </select>
                                                @error('paypal_mode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted">You need to Check your PayPal keys first before submitting.
                                </p>
                                <button type="button" class="btn btn-info check-api-keys"
                                    data-gateway="paypal">Check</button>
                                <button type="submit" class="btn btn-primary confirm-button" disabled>Submit</button>
                                <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                        {{-- <hr class="my-4"> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('validation.payment-settings')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js') }}"></script>
        {{-- <script>
            jQuery(document).ready(function() {
                jQuery(document).on('click', '.check-api-keys', function() {
                    var publicKey = jQuery('#publicKey').val();
                    var secretKey = jQuery('#secretKey').val();
                    const CSRF = jQuery("meta[ name='csrf-token']").attr("content")
                    if (publicKey == '' || secretKey == '') {
                        toastMsg('warning', 'Please fill the complete details', '#F5B759');
                    } else {
                        jQuery(this).html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Checking..');
                        jQuery(this).prop('disabled', true);
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('admin.payment-settings.stripe.keys') }}',
                            data: {
                                _token: CSRF,
                                public_key: publicKey,
                                secret_key: secretKey,
                            },
                            success: function(response) {
                                jQuery('.check-api-keys').html('Check');
                                jQuery('.check-api-keys').prop('disabled', false);
                                if (response.status == 'success') {
                                    jQuery('.confirm-button').prop('disabled', false);
                                    toastMsg('success', response.message, '#262B40');
                                } else {
                                    toastMsg('error', response.message, '#FA5252');
                                }
                            },
                            error: function(xhr, status, error) {
                                jQuery('.check-api-keys').html('Check');
                                jQuery('.check-api-keys').prop('disabled', false);
                                toastMsg('error', 'An error occurred while checking the keys.', '#FA5252');
                            }
                        });
                    }

                })
            })
        </script> --}}
        <script>
            jQuery(document).ready(function() {
                // Initialize verification statuses
                let stripeKeysVerified = false;
                let paypalKeysVerified = false;

                // Function to update submit button state
                function updateSubmitButtonState() {
                    if (stripeKeysVerified || paypalKeysVerified) {
                        jQuery('.confirm-button').prop('disabled', false);
                    } else {
                        jQuery('.confirm-button').prop('disabled', true);
                    }
                }

                // Initial state of the submit button
                updateSubmitButtonState();

                jQuery(document).on('click', '.check-api-keys', function() {
                    const $thisButton = jQuery(this); // Store reference to the clicked button
                    const gateway = $thisButton.data('gateway'); // Get the gateway from data attribute
                    const CSRF = jQuery("meta[name='csrf-token']").attr("content");

                    let publicKey, secretKey, paypalMode;
                    let url;
                    let dataToSend = {};

                    // Determine which keys to get and which URL to hit based on the gateway
                    if (gateway === 'stripe') {
                        publicKey = jQuery('#stripe_public_key').val();
                        secretKey = jQuery('#stripe_secret_key').val();
                        url = '{{ route('admin.payment-settings.check-stripe-details') }}';
                        dataToSend = {
                            _token: CSRF,
                            public_key: publicKey,
                            secret_key: secretKey,
                        };
                    } else if (gateway === 'paypal') {
                        publicKey = jQuery('#paypal_client_id').val(); // PayPal uses client_id
                        secretKey = jQuery('#paypal_client_secret').val(); // PayPal uses client_secret
                        paypalMode = jQuery('#paypal_mode').val();
                        url = '{{ route('admin.payment-settings.check-paypal-details') }}';
                        dataToSend = {
                            _token: CSRF,
                            paypal_client_id: publicKey, // Send as paypal_client_id
                            paypal_client_secret: secretKey, // Send as paypal_client_secret
                            paypal_mode: paypalMode,
                        };
                    } else {
                        // Should not happen if data-gateway is correctly set
                        toastMsg('error', 'Unknown payment gateway selected.', '#FA5252');
                        return;
                    }

                    // Basic validation
                    if (publicKey === '' || secretKey === '') {
                        toastMsg('warning', 'Please fill the complete details for ' + gateway.charAt(0)
                            .toUpperCase() + gateway.slice(1) + '.', '#F5B759');
                        return; // Stop execution if fields are empty
                    }

                    // Show loading state
                    $thisButton.html(
                        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Checking..'
                    );
                    $thisButton.prop('disabled', true);

                    // Make the AJAX request
                    jQuery.ajax({
                        type: 'POST',
                        url: url,
                        data: dataToSend,
                        success: function(response) {
                            $thisButton.html('Check ' + gateway.charAt(0).toUpperCase() + gateway
                                .slice(1) + ' Keys'); // Reset button text
                            $thisButton.prop('disabled', false); // Enable button

                            if (response.status === 'success') {
                                toastMsg('success', response.message, '#262B40');
                                if (gateway === 'stripe') {
                                    stripeKeysVerified = true;
                                } else if (gateway === 'paypal') {
                                    paypalKeysVerified = true;
                                }
                            } else {
                                toastMsg('error', response.message, '#FA5252');
                                if (gateway === 'stripe') {
                                    stripeKeysVerified = false;
                                } else if (gateway === 'paypal') {
                                    paypalKeysVerified = false;
                                }
                            }
                            updateSubmitButtonState(); // Update submit button state after check
                        },
                        error: function(xhr, status, error) {
                            $thisButton.html('Check ' + gateway.charAt(0).toUpperCase() + gateway
                                .slice(1) + ' Keys'); // Reset button text
                            $thisButton.prop('disabled', false); // Enable button
                            toastMsg('error', 'An error occurred while checking ' + gateway +
                                ' keys.', '#FA5252');
                            if (gateway === 'stripe') {
                                stripeKeysVerified = false;
                            } else if (gateway === 'paypal') {
                                paypalKeysVerified = false;
                            }
                            updateSubmitButtonState(); // Update submit button state even on error
                        }
                    });
                });

                // Event listeners to reset verification status when input fields change
                jQuery('#stripe-panel input').on('input', function() {
                    stripeKeysVerified = false;
                    updateSubmitButtonState();
                });

                jQuery('#paypal-panel input, #paypal-panel select').on('input', function() {
                    paypalKeysVerified = false;
                    updateSubmitButtonState();
                });

                // Event listener for tab changes (using Bootstrap's 'shown.bs.tab' event)
                jQuery('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    // Reset verification status when the active tab changes.
                    // This ensures users re-check keys if they switch tabs.
                    stripeKeysVerified = false;
                    paypalKeysVerified = false;
                    updateSubmitButtonState();
                });
            });
        </script>
    @endpush
</x-admin-layout>
