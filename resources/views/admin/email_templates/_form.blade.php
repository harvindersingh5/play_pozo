{{-- Template Name --}}
<div class="mb-3">
    <label for="name" class="form-label">Template Name (Unique Slug):</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
        id="name" name="name" value="{{ old('name', $emailTemplate->name ?? '') }}"
        placeholder="e.g., registration_confirmation">
    @error('name')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
    <div class="form-text">Use a unique, lowercase, slug-like name for internal identification.</div>
</div>

{{-- Subject --}}
<div class="mb-3">
    <label for="subject" class="form-label">Subject:</label>
    <input type="text" class="form-control @error('subject') is-invalid @enderror"
        id="subject" name="subject" value="{{ old('subject', $emailTemplate->subject ?? '') }}"
        placeholder="e.g., Welcome to {{ config('app.name') }}!">
    @error('subject')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
    <div class="form-text">You can use variables like @{{ $user_name }} in the subject.</div>
</div>

{{-- Email Body (Quill Editor) --}}
<div class="mb-3">
    <label for="body" class="form-label">Email Body:</label>
    <div class="position-relative">
        <div id="quill-toolbar" class="border-top border-start border-end rounded-top">
            </div>
        <div id="quill-editor" class="border rounded-bottom" style="min-height: 350px;">
            {!! old('body', $emailTemplate->body ?? '') !!} {{-- Pre-fill for edit/old input --}}
        </div>
        {{-- Hidden textarea to store Quill's HTML content --}}
        <textarea class="form-control @error('body') is-invalid @enderror d-none"
            id="body" name="body">{{ old('body', $emailTemplate->body ?? '') }}</textarea>
        <span class="invalid-txt" role="alert" style="display:none"></span>
    </div>
    @error('body')
        <div class="invalid-feedback d-block">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
    <div class="form-text mt-2">
        Use the rich text editor above to format your email content.
        Click the "Variable" button in the toolbar to insert dynamic variables like @{{ $user_name }}.
    </div>
</div>

{{-- Expected Variables --}}
<div class="mb-3">
    <label for="variables" class="form-label">Expected Variables (comma-separated):</label>
    <input type="text" class="form-control @error('variables') is-invalid @enderror"
        id="variables" name="variables" value="{{ old('variables', $emailTemplate->variables ?? '') }}"
        placeholder="e.g., user_name, verification_link, order_total">
    @error('variables')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
    <div class="form-text">List variables that this template expects. This helps with documentation and reference.</div>
</div>

{{-- Description --}}
<div class="mb-3">
    <label for="description" class="form-label">Description:</label>
    <textarea class="form-control @error('description') is-invalid @enderror"
        id="description" name="description" rows="3"
        placeholder="Brief description of when and how this template is used...">{{ old('description', $emailTemplate->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
    <div class="form-text">A brief internal description of this template's purpose and usage.</div>
</div>
