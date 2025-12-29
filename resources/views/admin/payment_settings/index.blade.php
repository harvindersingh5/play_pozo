<x-admin-layout>
    @section('title', 'Payment Settings')
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
                    <li class="breadcrumb-item active" aria-current="page">Payment Settings</li>
                </ol>
            </nav>
            <h2 class="h4">Payment Settings</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.payment-settings.create') }}"
                class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Add Payment Method
            </a>
        </div>
    </div>
    @include('admin.common.notification')
    <div class="table-settings">
        <div class="table-settings mb-4">
            <div class="row justify-content-end align-items-center">
                <div class="col-auto">
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
                                <a class="dropdown-item fw-bold rounded-bottom pagination-number"
                                    data-paginationNumber="30" href="javascript:;">30</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <div class="card-body">
            <div id="userList">
                <h5>Stripe Details</h5>
                <x-payment-settings-list :settings="$settings" />
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.payment-status-toggle').on('change', function() {
                    const paymentSettingId = $(this).data('id');
                    const gateway = $(this).data('gateway');
                    const isChecked = $(this).is(':checked');
                    const $currentToggle = $(this);
                    const $currentStatusText = $currentToggle.closest('.form-check').find('.status-text');

                    let url = '{{ route('admin.payment-settings.update-status') }}';
                    let formData = {
                        id: paymentSettingId,
                        gateway: gateway,
                        status: isChecked
                    };

                    if (isChecked) {
                        Swal.fire({
                            title: 'Confirm Activation?',
                            text: `Activating ${gateway.toUpperCase()} will deactivate any other currently active payment methods. Proceed?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1F2937',
                            cancelButtonColor: '#fb503b',
                            confirmButtonText: 'Yes, activate it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let response = ajaxCall(url, 'post', formData);
                                response.then((response) => {
                                    if (response.success) {
                                        Swal.fire('Activated!',
                                            `${gateway.toUpperCase()} has been activated.`,
                                            'success');
                                        $('.payment-status-toggle').not($currentToggle)
                                            .each(function() {
                                                $(this).prop('checked',
                                                    false); 
                                                $(this).closest('.form-check').find(
                                                        '.status-text')
                                                    .removeClass('text-success')
                                                    .addClass('text-danger').text(
                                                        'Inactive');
                                            });

                                        $currentToggle.prop('checked', true);
                                        $currentStatusText.removeClass('text-danger')
                                            .addClass('text-success').text('Active');

                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                        $currentToggle.prop('checked', !
                                            isChecked);
                                        $currentStatusText.removeClass('text-success')
                                            .addClass('text-danger').text(
                                                'Inactive'); 
                                    }
                                }).catch((error) => {
                                    console.error('Ajax call failed:', error);
                                    Swal.fire('Error!',
                                        'Something went wrong. Please try again.',
                                        'error');
                                    $currentToggle.prop('checked', !
                                        isChecked);
                                    $currentStatusText.removeClass('text-success')
                                        .addClass('text-danger').text('Inactive');
                                });
                            } else {
                                $currentToggle.prop('checked', !isChecked);
                            }
                        });
                    } else {
                        let response = ajaxCall(url, 'post', formData);
                        response.then((response) => {
                            if (response.success) {
                                Swal.fire('Deactivated!',
                                    `${gateway.toUpperCase()} has been deactivated.`,
                                    'success');
                                $currentStatusText.removeClass('text-success').addClass(
                                    'text-danger').text('Inactive');
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                                $currentToggle.prop('checked', !
                                    isChecked); 
                            }
                        }).catch((error) => {
                            console.error('Ajax call failed:', error);
                            Swal.fire('Error!', 'Something went wrong. Please try again.',
                                'error');
                            $currentToggle.prop('checked', !
                                isChecked);
                        });
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
