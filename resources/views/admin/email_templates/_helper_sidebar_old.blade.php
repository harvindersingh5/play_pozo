<div class="col-12 col-xl-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Template Variables Guide
            </h6>
        </div>
        <div class="card-body">
            <p class="small text-muted mb-3">
                Use these common variable patterns in your email templates:
            </p>

            <div class="mb-3">
                <h6 class="small fw-bold">User Variables:</h6>
                <code class="small d-block">@{{ $user_name }}</code>
                <code class="small d-block">@{{ $user_email }}</code>
                <code class="small d-block">@{{ $user_phone }}</code>
            </div>

            <div class="mb-3">
                <h6 class="small fw-bold">System Variables:</h6>
                <code class="small d-block">@{{ $app_name }}</code>
                <code class="small d-block">@{{ $app_url }}</code>
                <code class="small d-block">@{{ $current_date }}</code>
            </div>

            <div class="mb-3">
                <h6 class="small fw-bold">Action Variables:</h6>
                <code class="small d-block">@{{ $verification_link }}</code>
                <code class="small d-block">@{{ $reset_link }}</code>
                <code class="small d-block">@{{ $login_url }}</code>
            </div>

            <div class="alert alert-info p-2 small">
                <i class="fas fa-lightbulb me-1"></i>
                <strong>Tip:</strong> Use the "Variable" button in the editor toolbar to quickly insert variables.
            </div>
        </div>
    </div>
</div>