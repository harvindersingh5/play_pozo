<div class="col-9 col-lg-8 d-md-flex">
    <div class="input-group me-2 me-lg-3 fmxw-300">
        <span class="input-group-text">
            <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
            </svg>
        </span>
        <input type="text" id="searchUsers" class="form-control" placeholder="Search">
    </div>
    {{ $filterStatus ?? '' }}

     <select id="filterStatus" class="form-select fmxw-200 d-none d-md-inline"
        aria-label="Message select example 2">
         <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>All</option>
        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
    </select>
</div>