<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the email templates.
     */
    public function index(Request $request)
    {
        try {
            $query = EmailTemplate::query();

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->has('status')) {
                if ($request->status != 'All') {
                    $query->status($request->status);
                }
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $templates = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.email-templates-list', compact('templates'))->render(),
                ]);
            }

            // Return view for non-AJAX requests
            return view('admin.email_templates.index', compact('templates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new email template.
     */
    public function create()
    {
        return view('admin.email_templates.create');
    }

    /**
     * Store a newly created email template in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:email_templates'],
                'subject' => ['required', 'string', 'max:255'],
                'body' => ['required', 'string'],
                'description' => ['required', 'string', 'max:1000'],
                'variables' => ['nullable', 'string'], // Expected variables as a comma-separated string
            ]);

            // Convert variables string to array
            $validated['variables'] = array_filter(array_map('trim', explode(',', $validated['variables'] ?? '')));

            EmailTemplate::create($validated);

            return redirect()->route('admin.email-templates.index')->with('success', 'Email template created successfully!');
        } catch (\Exception $e) {
            \Log::info("Template creation error: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified email template.
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        // Convert variables array back to comma-separated string for display
        $emailTemplate->variables = implode(', ', $emailTemplate->variables ?? []);
        return view('admin.email_templates.edit', compact('emailTemplate'));
    }

    /**
     * Update the specified email template in storage.
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('email_templates')->ignore($emailTemplate->id)],
                'subject' => ['required', 'string', 'max:255'],
                'body' => ['required', 'string'],
                'description' => ['nullable', 'string', 'max:1000'],
                'variables' => ['nullable', 'string'],
            ]);

            $validated['variables'] = array_filter(array_map('trim', explode(',', $validated['variables'] ?? '')));

            $emailTemplate->update($validated);

            return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated successfully!');
        } catch (\Exception $e) {
            \Log::info("Template update error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update email template: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified email template from storage.
     */
    public function destroy($id)
    {
        try {
            $id = jsdecode_userdata($id);
            if (empty($id)) {
                return redirect()->back()->with('error', 'Invalid template ID.');
            }
            $emailTemplate = EmailTemplate::findOrFail($id);
            $emailTemplate->delete();
            return redirect()->route('admin.email-templates.index')->with('success', 'Email template deleted successfully.');
        } catch (\Exception $e) {
            \Log::info("Template delete error");
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function applyEmailTemplate(Request $request)
    {

        try {
            $request->validate([
                'perform_action' => 'required|in:ACTIVE,INACTIVE',
                'template_ids' => 'required|array',
                'template_ids.*' => 'exists:email_templates,id',
            ]);

            $action = $request->perform_action;
            $templateIds = $request->template_ids;
            DB::beginTransaction();

            $status = $action === 'ACTIVE' ? true : false;

            EmailTemplate::whereIn('id', $templateIds)->update(['status' => $status]);

            DB::commit();
            $query = EmailTemplate::query();
            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $templates = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            return response()->json([
                'html' => view('components.email-templates-list', compact('templates'))->render(),
                'status' => true,
                'data' => [],
                'message' => 'Template status updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info("Template status update error" . $e->getMessage());
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Failed to update template status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
