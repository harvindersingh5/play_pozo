<x-admin-layout>
    @php
        $plan = isset($plan) ? $plan : new \App\Models\Plan();
    @endphp
    @section('title', $plan->exists ? 'Edit Plan' : 'Add Plan')
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">Plan List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $plan->exists ? 'Edit Plan' : 'Add Plan' }}</li>
                    </ol>
                </nav>
                <h2 class="h4">{{ $plan->exists ? 'Edit Plan' : 'Add Plan' }}</h2>
            </div>
        </div>
        @include('admin.common.notification')
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card card-body shadow-sm mb-4">
                    <form method="POST"
                        action="{{ $plan->exists ? route('admin.plan.save', $plan->id) : route('admin.plan.save') }}"
                        id="plan-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="name">Plan Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        type="text" placeholder="Plan Name" name="name"
                                        value="{{ old('name', $plan->name) }}">
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
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input class="form-control @error('price') is-invalid @enderror" id="price"
                                        type="number" placeholder="Price" name="price"
                                        value="{{ old('price', $plan->price) }}">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="validity">Validity</label>
                                <select class="form-select mb-0 @error('validity') is-invalid @enderror" id="validity"
                                    aria-label="validity select example" name="validity">
                                    <option value="">Select Validity</option>
                                    <option value="WEEKLY"
                                        {{ old('validity', $plan->validity) == 'WEEKLY' ? 'selected' : '' }}>Weekly
                                    </option>
                                    <option value="MONTHLY"
                                        {{ old('validity', $plan->validity) == 'MONTHLY' ? 'selected' : '' }}>Monthly
                                    </option>
                                    <option value="ANNUAL"
                                        {{ old('validity', $plan->validity) == 'ANNUAL' ? 'selected' : '' }}>Annual
                                    </option>
                                </select>
                                @error('validity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Description"
                                        name="description">{{ old('description', $plan->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status">Status</label>
                                <select class="form-select mb-0 @error('status') is-invalid @enderror" id="status"
                                    aria-label="status select example" name="status">
                                    <option value="ACTIVE"
                                        {{ old('status', $plan->status) == 'ACTIVE' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="INACTIVE"
                                        {{ old('status', $plan->status) == 'INACTIVE' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">Save
                                Plan</button>
                            <a href="{{ route('admin.plan.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
    <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js')}}"></script>
        @include('validation.plan-form')
    @endpush
</x-admin-layout>
