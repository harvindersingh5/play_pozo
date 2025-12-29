
<x-admin-layout>
    @section('title', 'Two Factor Enabled')
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
                        <li class="breadcrumb-item active">Two Factor Enabled
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">Two Factor Enabled</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <form action="{{ route('admin.settings.two-factor-enabled') }}" method="POST"
                            enctype="multipart/form-data" id="two_factor_enabled">
                            @csrf
                            <div class="row">
                                 <div class="col-md-6 mb-3">
                                <label for="two_factor_enabled">Two Factor Enabled</label>
                                <select class="form-select mb-0  @error('two_factor_enabled') is-invalid @enderror" id="two_factor_enabled"
                                    aria-label="two_factor_enabled select example" name="two_factor_enabled">
                                    <option value="INACTIVE" {{ optional($setting)->value == "INACTIVE" ? 'selected' : '' }}>Inactive</option>
                                    <option value="ACTIVE" {{ optional($setting)->value == "ACTIVE" ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Save</button>
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
                    two_factor_enabled: {
                        required: true,
                    },
                  
                }
                const messages = {
                    two_factor_enabled: {
                        required: `This field is required.`,
                    },
                    

                };

                handleValidation('two_factor_enabled', rules, messages);

               

                $('#two_factor_enabled').on('submit', function(event) {
                    if ($('#two_factor_enabled').valid()) {
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
