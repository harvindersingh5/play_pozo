<x-admin-layout>
    @section('title', 'Edit Commission')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.commission.index') }}">Commissions List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Commission</li>
                    </ol>
                </nav>
                <h2 class="h4">Edit Commission</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card card-body shadow-sm mb-4">
                    <form method="POST" action="{{ route('admin.commission.update', $commission->id) }}"
                        id="edit-commission">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $commission->name) }}" placeholder="Commission Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="type">Type</label>
                                    <select name="type" id="type"
                                        class="form-select form-control @error('type') is-invalid @enderror">
                                        <option value="FLAT"
                                            {{ old('type', $commission->type) == 'FLAT' ? 'selected' : '' }}>Flat
                                        </option>
                                        <option value="PERCENTAGE"
                                            {{ old('type', $commission->type) == 'PERCENTAGE' ? 'selected' : '' }}>
                                            Percentage</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="value">Value</label>
                                    <input type="text" name="value" id="value"
                                        class="form-control @error('value') is-invalid @enderror"
                                        value="{{ old('value', $commission->value) }}" placeholder="Commission Value">
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Save</button>
                            <a href="{{ route('admin.commission.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js')}}"></script>
    @include('validation.commission')
    @endpush
</x-admin-layout>
