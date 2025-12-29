<x-admin-layout>
    @section('title', 'SubAdmin List')
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
                    <li class="breadcrumb-item active" aria-current="page">Subadmin List</li>
                </ol>
            </nav>
            <h2 class="h4">Subadmin List</h2>
        </div>
    </div>
    @include('admin.common.notification')
    {{-- @include('admin.common.share_user_data') --}}
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            {{-- <form id="userFilterForm"> --}}
                <x-search-form />
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
        <div class="d-flex mb-3">
            <select class="form-select fmxw-200" id="applyUserAction" aria-label="Message select example">
                @foreach(get_status() as $value)
                    <option value="{{$value}}">{{ucfirst(strtolower($value))}}</option>
                @endforeach
            </select>
            <button class="btn btn-sm px-3 btn-secondary ms-3" id="applyUserBtn">Apply</button>
        </div>
        <div class="card-body">
            <div id="userList">
                <x-user-list :users="$users" />
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script>
            $(document).ready(function() {
                let currentPaginationNumber = 10;

                function fetchUsers() {
                    let search = $("#searchUsers").val();
                    let status = $("#filterStatus").val();

                    $.ajax({
                        url: "{{ route('admin.subadmin.index') }}",
                        type: "GET",
                        data: {
                            search: search,
                            status: status,
                            paginationNumber: currentPaginationNumber,
                        },
                        beforeSend: function() {
                            $("#userList").html('<p class="text-center">Loading...</p>');
                            // $('.overlay').css('display', 'block');
                        },
                        success: function(response) {
                            // $('.overlay').css('display', 'none');
                            $("#userList").html(response.html);
                        },
                        error: function() {
                            alert("Error fetching user data.");
                        }
                    });
                }

                // Call function when search input or status dropdown changes
                $("#searchUsers, #filterStatus").on("keyup change", function() {
                    fetchUsers();
                });

                // Handle pagination number selection
                $(".pagination-number").on("click", function() {
                    // $(".pagination-number").find(".check-icon").remove();
                    $('.pagination-number').find('.icon.icon-xxs').remove();
                    $('.pagination-number').find('.d-flex.align-items-center').remove();
                    let checkElement = $('.pagination-number');
                    if (checkElement.hasClass('custom-check-pagination')) {
                        checkElement.removeClass('custom-check-pagination');
                    }
                    $(this).addClass('d-flex align-items-center');
                    $(this).addClass('custom-check-pagination');
                    $(this).append(
                        `<svg class="icon icon-xxs ms-auto check-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>`
                    );

                    currentPaginationNumber = $(this).data("paginationnumber");

                    fetchUsers();
                });


                // here the code for apply action
                $(document).on('click', '#checkAllUser', function() {
                    var isChecked = $(this).prop('checked');
                    $('.user-checkbox').prop('checked', isChecked);
                });

                $('#applyUserBtn').on('click', function() {
                    var selectedAction = $('#applyUserAction').val();
                    var userIds = [];

                    $('.user-checkbox:checked').each(function() {
                        userIds.push($(this).val());
                    });
                    let checkElement = $('.custom-check-pagination');
                    currentPaginationNumber = checkElement.attr('data-paginationnumber');

                    if (userIds.length > 0) {

                        let url = '{{ route('admin.users.apply') }}';
                        let data = {
                            user_ids: userIds,
                            perform_action: selectedAction,
                            paginationNumber: currentPaginationNumber,
                        };

                        let response = ajaxCall(url, 'GET', data);
                        response.then((response) => {
                            if (response.status == true) {
                                $("#userList").html(response.html);
                                toastMsg('success', 'User status updated successfully', '#262B40');
                            } else {
                                console.log('error', response.message);
                            }
                        }).catch((error) => {
                            console.error('Ajax call failed:', error);
                        });
                    } else {
                        toastMsg('error', 'Please select atleast one user', '#FA5252');
                    }
                });

                $('#exportDetails').click(function() {
                    window.location.href = '{{ route('admin.users.download-csv') }}';
                });

                // Here is the code for send the users csv file
                $('.share-csv-btn').click(function(e) {
                    e.preventDefault();

                    $("#share-user-csv").validate({
                        rules: {
                            email: {
                                required: true,
                                email: true,
                                maxlength: emailMaxLength,
                                regex: emailRegex,
                            },
                        },
                        email: {
                            required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                            email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                            regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                            maxlength: `{{ __('custom_messages.user.emailMax', ['attribute' => 'email', 'emailMax' => '254']) }}`,
                        },
                    });

                    let url = '{{ route('admin.users.share-csv') }}';
                    let form = $('#share-user-csv');
                    let data = new FormData(form[0]);
                    if (jQuery('#share-user-csv').valid()) {
                        jQuery('.share-csv-btn').prop('disabled', true);
                        let response = ajaxCall(url, 'post', data);
                        response.then((response) => {
                            if (response.status == true) {
                                $('#modal-share').modal('hide');
                                $('#share-user-csv')[0].reset();
                                jQuery('.share-csv-btn').prop('disabled', false);

                                toastMsg('success', 'Email send successfully', '#262B40');
                            } else {
                                console.log('error', response.message);
                            }
                        }).catch((error) => {
                            console.error('Ajax call failed:', error);
                        });
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
