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
                        <h1 class="h3 mb-4">OTP Verification</h1>
                    </div>
                    <form action="{{ route('otp.verify') }}" id="otp-form" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="password">OTP</label>
                            <div class="input-group">
                               
                                <input type="text" placeholder="123456"
                                    class="form-control  @error('otp') is-invalid @enderror" id="otp" name="otp" value="{{ old('otp') }}">
                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                     <div class="d-grid">
                            <button type="submit" class="btn btn-gray-800 update-pass-btn">Submit</button>
                        </div>
                    </form>
                    <p><a href="{{ route('otp.resend') }}">Resend otp</a></p>
                </div>
            </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
   
    jQuery(document).ready(function() {
        const rules = {
            otp: {
                required: true,
            },
         
        };

        const messages = {
            otp: {
                required: `This is required field`,
            },
         
        };

        handleValidation('otp-form', rules, messages);
    });
</script>

@endpush
</x-auth-layout>
