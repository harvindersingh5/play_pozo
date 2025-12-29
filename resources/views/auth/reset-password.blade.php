<x-auth-layout>
     <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

    @section('title', 'Reset Password')
    @include('admin.common.notification')
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="container">
            <div class="row justify-content-center form-bg-image">
                {{-- <p class="text-center"><a href="{{ route('login') }}"
                        class="d-flex align-items-center justify-content-center">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Back to log in
                    </a>
                </p> --}}
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                        <h1 class="h3 mb-4">Reset password</h1>
                        <form action="{{ route('password.store') }}" method="POST" id="reset-password-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <input type="hidden" name='email' value="{{ $request->email }}">
                            {{-- <div class="mb-4">
                                <label for="email">Your Email</label>
                                <div class="input-group">
                                     <span class="input-group-text" id="basic-addon2">
                                    <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                        </path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="example@company.com" id="email"
                                        value="{{ old('email', $request->email) }}" readonly>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- End of Form -->
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password">Your Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </span>
                                    <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password"
                                        id="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- End of Form -->
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </span>
                                    <input type="password" placeholder="Confirm Password" class="form-control"
                                        id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                            <!-- End of Form -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gray-800">Reset password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @include('validation.reset-password-form')
    @endpush
</x-auth-layout>
