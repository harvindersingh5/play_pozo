<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = CmsPage::query();

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));

            $cmsPages = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.cms-page-list', compact('cmsPages'))->render(),
                ]);
            }
            return view('admin.cms.index', compact('cmsPages'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(string $slug)
    {
        $cmsPage = CmsPage::where('slug', $slug)->firstOrFail();
        return view('admin.cms.edit', compact('cmsPage'));
    }

    public function update(Request $request, CmsPage $page)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:100',
            'meta_title' => 'required|string|min:3|max:100',
            'meta_description' => 'required|string|min:3|max:160',
            'tag_line' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:50|max:5000',
        ], [
            'title.required' => 'Please enter the title',
            'meta_title.required' => 'Please enter the meta title',
            'meta_description.required' => 'Please enter the meta description',
            'tag_line.required' => 'Please enter the tag line',
            'content.required' => 'Please enter the content',
        ]);

        try {
            $page->update($request->only(['title', 'meta_title', 'meta_description', 'tag_line', 'content']));
            return redirect()->route('admin.cms.index')->with('success', 'CMS Page updated successfully');
        } catch (\Exception $e) {
            Log::error('Error in updateCmsPage: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the CMS page.');
        }
    }
}
