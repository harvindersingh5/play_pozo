<table class="table user-table table-hover align-items-center">
    <thead>
        <tr>
            {{-- <th class="border-bottom">#</th> --}}
            <th class="border-bottom">
                <div class="form-check dashboard-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkAllUser">
                    <label class="form-check-label" for="checkAllUser"></label>
                </div>
            </th>
            <th class="border-bottom">Name</th>
            <th class="border-bottom">Subject</th>
            <th class="border-bottom">Status</th>
            <th class="border-bottom">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($templates as $template)
            <tr>
                {{-- <td>{{ $loop->iteration }}</td> --}}
                <td>
                    <div class="form-check dashboard-check">
                        <input class="form-check-input user-checkbox" type="checkbox" value="{{ $template->id }}"
                            id="userCheck{{ $template->id }}">
                        <label class="form-check-label" for="userCheck{{ $template->id }}"></label>
                    </div>
                </td>
                <td>
                    <div class="d-block">
                        <span class="fw-bold">{{ $template->name ?? '-' }}</span>
                    </div>
                </td>
                <td>
                    <div class="d-block">
                        <span class="fw-bold">{{ $template->subject ?? '-' }}</span>
                    </div>
                </td>
                 <td>
                    <span class="fw-normal {{ $template->status ? 'text-success' : 'text-danger' }}">
                        {{ $template->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                </path>
                            </svg>
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                            <a class="dropdown-item d-flex align-items-center gap-1"
                                href="{{ route('admin.email-templates.edit', $template->id) }}">
                                <svg class="custom-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                </svg>
                                Edit
                            </a>
                            <a class="dropdown-item text-danger d-flex align-items-center gap-1" href="#"
                                onclick="confirmDelete(event, '{{ route('admin.email-templates.destroy', jsencode_userdata($template->id)) }}', 'Are you sure you want to delete this template?')">
                                <svg class="custom-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                    <path
                                        d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                </svg>
                                Delete Template
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">
                    Email template data not available.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- @if ($templates->hasPages()) --}}
@if ($templates->count() > 0)
    <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        <nav aria-label="Page navigation example">
            <ul class="pagination mb-0">
                {{ $templates->links('pagination::bootstrap-5') }}
            </ul>
        </nav>
        <div class="fw-normal small mt-4 mt-lg-0">Showing
            <b>{{ $templates->lastItem() - $templates->firstItem() + 1 }}</b> out of <b>{{ $templates->total() }}</b>
            entries
        </div>
    </div>
@endif
