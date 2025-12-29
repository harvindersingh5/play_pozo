<x-admin-layout>
    @section('title', $role ? 'Edit Role' : 'Add Role')
    @push('styles')
        <style>
            .form-group {
                margin-bottom: 15px;
            }
            .form-group h5 {
                margin-bottom: 5px;
            }
            .form-group .d-flex.flex-wrap {
                display: flex;
                flex-wrap: nowrap;
                justify-content: space-between;
                width: 100%;
            }
            .form-group .permission-group {
                display: flex;
                align-items: center;
                margin-right: 0;
                flex-grow: 1;
                flex-basis: 0;
            }
            .form-group .form-check {
                display: flex;
                align-items: center;
                margin-right: 0;
            }
            .form-group .form-check-input {
                margin-right: 5px;
            }
            .form-group .form-check label {
                white-space: nowrap;
            }
            label {
                margin-bottom: 0rem;
                margin-left: 5px;
            }
        </style>
    @endpush
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Roles List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $role ? 'Edit Role' : 'Add Role' }}
                        </li>
                    </ol>
                </nav>
                <h2 class="h4">{{ $role ? 'Edit Role' : 'Add Role' }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card card-body shadow-sm mb-4">
                    <form action="{{ $role ? route('admin.role.store', $role->id) : route('admin.role.store') }}"
                        method="POST" id="create-role">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <label for="name">Role Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        type="text" placeholder="Role Name" name="name"
                                        value="{{ old('name', $role->name ?? '') }}">
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
                                <label for="permissions">Permissions</label>
                                @forelse($permissions as $groupName => $groupPermissions)
                                    <div class="form-group">
                                        <h5>{{ ucfirst($groupName) }}</h5>
                                        <div class="d-flex flex-wrap">
                                            @foreach ($groupPermissions as $permission)
                                                <div class="permission-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" class="form-check-input"
                                                            id="permission-{{ $permission->id }}"
                                                            {{ in_array($permission->name, old('permissions', $rolePermissions ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission-{{ $permission->id }}">
                                                            {{ $permission->label }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <p>No permissions found.</p>
                                @endforelse
                                @error('permissions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit"
                                class="btn btn-gray-800 mt-2 animate-up-2 save-all-btn">{{ $role ? 'Update' : 'Save' }}</button>
                            <a href="{{ route('admin.role.index') }}" class="btn btn-secondary mt-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/admin/js/unsaved-changes-warning.js') }}"></script>
        @include('validation.role')
    @endpush
</x-admin-layout>
