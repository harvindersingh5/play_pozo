<x-admin-layout>
    @section('title', 'Create Size')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.settings.thumbnail.index') }}">Thumbnail
                                Sizes</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Size</li>
                    </ol>
                </nav>
                <h2 class="h4">Add Size</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ route('admin.settings.thumbnail.store') }}" method="POST" id="create-size">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="modal_name" class="form-label">
                                        Size Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="e.g. small, medium, large" required value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_width" class="form-label">
                                        Width (pixels) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="width" id="width" class="form-control"
                                        min="1" max="5000" required value="{{ old('width') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_height" class="form-label">
                                        Height (pixels) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="height" id="height" class="form-control"
                                        min="1" max="5000" required value="{{ old('height') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Quick Presets</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm quick-size"
                                        data-name="thumbnail" data-width="150" data-height="150">
                                        150×150
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm quick-size"
                                        data-name="small" data-width="300" data-height="200">
                                        300×200
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm quick-size"
                                        data-name="medium" data-width="600" data-height="400">
                                        600×400
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm quick-size"
                                        data-name="large" data-width="1200" data-height="800">
                                        1200×800
                                    </button>
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
            $(document).ready(function() {
                $(".quick-size").on('click', function(e) {
                    let name = $(this).data('name');
                    let width = $(this).data('width');
                    let height = $(this).data('height');

                    $("#name").val(name);
                    $("#width").val(width);
                    $("#height").val(height);
                });


                const rules = {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 10,
                    },
                    width: {
                        required: true,
                    },
                    height: {
                        required: true,
                    },

                }
                const messages = {
                    name: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'size name']) }}`,
                        minlength: `{{ __('custom_messages.user.min', ['attribute' => 'size name', 'min' => '3']) }}`,
                        maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'size name', 'max' => '10']) }}`,
                    },
                    width: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'size width']) }}`,
                    },
                    height: {
                        required: `{{ __('custom_messages.user.required', ['attribute' => 'size height']) }}`,
                    },

                };

                handleValidation('create-size', rules, messages);

                $('#create-size').on('submit', function(event) {
                    if ($('#create-size').valid()) {
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
