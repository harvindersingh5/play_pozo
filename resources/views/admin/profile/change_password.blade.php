<x-admin-layout>
    @section('title', 'Change Password')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                    </ol>
                </nav>
                <h2 class="h4">Change Password</h2>
            </div>
        </div>
        <div class="col-6 col-lg-6">
            <div class="card card-body shadow-sm mb-4">
                @include('admin.common.notification')
                <form action="{{ route('admin.update-password') }}" method="POST" id="update-password">
                    @csrf
                    <div class="mb-4">
                        <label for="current_password">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" placeholder="Current Password">
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="cPassword">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="cPassword" name="password" placeholder="New Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-eye-slash"></i>
                            </span>
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                                id="confirm_password" name="confirm_password" placeholder="Confirm New Password">
                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800 update-pass-btn">Reset password</button>
                        </div> --}}
                    <div class="mt-3">
                        <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Change
                            Password</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-2">Cancel</a>
                    </div>
                </form>
                {{-- <div class="mt-3 text-center">
                        <a href="{{ route('admin.dashboard') }}" class="d-inline-flex align-items-center">
                            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                    </div> --}}
            </div>
        </div>
    </div>
    @push('scripts')
        @include('validation.admin_update_password')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js')}}"></script>
        <script>
            $(document).ready(function() {
                $('#update-password').on('submit', function() {
                    if ($('#update-password').valid()) {
                        $('.update-pass-btn').prop('disabled', true);
                        $('.overlay').css('display', 'block');
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
