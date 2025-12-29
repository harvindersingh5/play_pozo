<table class="table user-table table-hover align-items-center">
    <thead>
        <tr>
            <th class="border-bottom">
                <div class="form-check dashboard-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkAllUser">
                    <label class="form-check-label" for="checkAllUser"></label>
                </div>
            </th>
            <th class="border-bottom">Icon</th>
            <th class="border-bottom">Name</th>
            <th class="border-bottom">Parent Category</th>
            <th class="border-bottom">Status</th>
            <th class="border-bottom">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
            <tr>
                <td>
                    <div class="form-check dashboard-check">
                        <input class="form-check-input user-checkbox" type="checkbox" value="{{ $category->id }}"
                            id="userCheck{{ $category->id }}">
                        <label class="form-check-label" for="userCheck{{ $category->id }}"></label>
                    </div>
                </td>
                <td>
                    <img src="{{ $category->category_image_url }}" class="avatar rounded-circle me-3" alt="Avatar">
                </td>
                <td>
                    <div class="d-block">
                        <span class="fw-bold">{{ $category->name ?? 'N/A' }}</span>
                    </div>
                </td>
                <td>
                    <span class="fw-normal">
                        @if ($category->parent_id)
                            {{ $category->parent->name ?? '-' }}
                        @else
                            -
                        @endif
                    </span>
                </td>
                <td>
                    <span class="fw-normal {{ $category->status === 'ACTIVE' ? 'text-success' : 'text-danger' }}">
                        {{ $category->status }}
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
                            {{-- @can('user-view')
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('admin.users.show', jsencode_userdata($category->id)) }}">
                                    <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    View Details
                                </a>
                            @endcan --}}

                            @can('user-edit')
                                <a class="dropdown-item d-flex align-items-center gap-1"
                                    href="{{ route('admin.category.edit', jsencode_userdata($category->id)) }}">
                                    <svg class="custom-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                    </svg>
                                    Edit
                                </a>
                            @endcan

                            @can('user-delete')
                                <a class="dropdown-item text-danger d-flex align-items-center gap-1" href="#"
                                    onclick="confirmDelete(event, '{{ route('admin.category.destroy', jsencode_userdata($category->id)) }}', 'Are you sure you want to delete this category?')">
                                    <svg class="custom-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <path
                                            d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                    </svg>
                                    Delete Category
                                </a>
                            @endcan

                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">
                    Category data not available.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
    <nav aria-label="Page navigation example">
        <ul class="pagination mb-0">
            {{ $categories->links('pagination::bootstrap-5') }}
        </ul>
    </nav>
    <div class="fw-normal small mt-4 mt-lg-0">Showing
        <b>{{ $categories->lastItem() - $categories->firstItem() + 1 }}</b> out of <b>{{ $categories->total() }}</b>
        entries
    </div>
</div>
