<x-auth-layout>
    @section('title', 'Login')
    @include('admin.common.notification')
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div class="row justify-content-center w-100">
            {{-- <div class="row justify-content-center form-bg-image" data-background-lg="/assets/custom/images/signin.svg"> --}}
            <div class="row justify-content-center form-bg-image" data-background-lg="">
            <div class="col-md-12 d-flex justify-content-center align-items-center">
                <div class="bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                    <div class="text-center text-md-center mb-4 mt-md-0">
                        <h1 class="h3 mb-4">Welcome Back</h1>
                    </div>
                    <form action="{{ route('login') }}" id="login-form" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="password">Your Email</label>
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
                                <input type="email" placeholder="example@company.com"
                                    class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password">Your Password</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </span>
                                <input type="password" placeholder="Password"
                                    class="form-control  @error('password') is-invalid @enderror" id="password"
                                    name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-top mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="remember" name="remember">
                                <label class="form-check-label mb-0" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <div>
                                <a href="{{ route('password.request') }}" class="small text-right">Lost password?</a>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800 update-pass-btn">Sign In</button>
                        </div>
                    </form>
                    <div class="d-flex justify-content-center align-items-center mt-4">
                        <span class="fw-normal">
                            Not registered?
                            <a href="{{ route('register') }}" class="fw-bold">Create account</a><br>
                            <a href="{{route('request.form')}}">Register request</a>
                        </span>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@push('scripts')
@include('validation.login-form')
@endpush
</x-auth-layout>
