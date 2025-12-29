<table class="table user-table table-hover align-items-center">
    <thead>
        <tr>
            <th class="border-bottom">#</th>
            <th class="border-bottom">Name</th>
            <th class="border-bottom">Type</th>
            <th class="border-bottom">Value</th>
            <th class="border-bottom">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($commissions as $commission)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span class="fw-normal">{{ $commission->name ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $commission->type ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $commission->value ?? 'N/A' }}</span>
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
                            @can('user-edit')
                                <a class="dropdown-item d-flex align-items-center gap-1"
                                    href="{{ route('admin.commission.edit', ['commission' => $commission->id]) }}">
                                    <svg class="custom-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z" />
                                    </svg>
                                    Edit
                                </a>
                            @endcan

                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">
                    Commision data not available.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
    <nav aria-label="Page navigation example">
        <ul class="pagination mb-0">
            {{ $commissions->links('pagination::bootstrap-5') }}
        </ul>
    </nav>
    <div class="fw-normal small mt-4 mt-lg-0">Showing <b>{{ ($commissions->lastItem() - $commissions->firstItem()) + 1 }}</b> out of <b>{{ $commissions->total() }}</b> entries</div>
</div>


