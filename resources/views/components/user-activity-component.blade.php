<table class="table user-table table-hover align-items-center">
    <thead>
        <tr>
            <th class="border-bottom">#</th>
            <th class="border-bottom">Name</th>
            <th class="border-bottom">Email</th>
            <th class="border-bottom">Activity</th>
            <th class="border-bottom">Status</th>
            <th class="border-bottom">IP</th>
            <th class="border-bottom">User Agent</th>
            <th class="border-bottom">Time</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($logs as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> <span class="fw-normal">{{ ucwords($log->user->first_name ?? 'N/A') }}</span></td>
                <td>
                    <span class="fw-normal">{{ $log->email ?? 'N/A' }}</span>
                </td>
                 <td>
                    <span class="fw-normal">{{ ucwords($log->activity) ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ ucfirst($log->status) ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $log->ip_address ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $log->user_agent ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="fw-normal">{{ $log->created_at ?? 'N/A' }}</span>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">
                    User activites not available.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
    <nav aria-label="Page navigation example">
        <ul class="pagination mb-0">
            {{ $logs->links('pagination::bootstrap-5') }}
        </ul>
    </nav>
    <div class="fw-normal small mt-4 mt-lg-0">Showing
        <b>{{ $logs->lastItem() - $logs->firstItem() + 1 }}</b> out of
        <b>{{ $logs->total() }}</b> entries
    </div>
</div>
