<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\ThumbnailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    protected $thumbnailService;

    public function __construct(ThumbnailService $thumbnailService)
    {
        $this->thumbnailService = $thumbnailService;
    }

    /**
     * Display a listing of categories.
     *
     */
    public function index(Request $request)
    {
        try {
            $query = Category::query();

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->has('status')) {
                if ($request->status != 'All') {
                    $query->status($request->status);
                }
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $categories = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.category-list', compact('categories'))->render(),
                ]);
            }

            // Return view for non-AJAX requests
            return view('admin.category.index', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Return the form to create the category
     */

    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.category.create', compact('categories'));
        } catch (\Exception $e) {
            \Log::info("Category Form creation error");
            return redirect()->back();
        }
    }

    /**
     * Store a newly created category in storage.
     *
     */
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('category_image')) {
                $categoryImagePath = store_image($request->file('category_image'), 'category_images');
                $data['cat_img_path'] = $categoryImagePath['url'] ?? null; 
            }
            
            $category = Category::create($data);

            // if ($request->hasFile('category_image')) {
            //     $this->thumbnailService->generateThumbnails(
            //         $request->file('category_image'),
            //         $category,
            //         [
            //             'small' => [100, 100],
            //             'medium' => [300, 200],
            //             'large' => [800, 600],
            //         ],
            //         'category_thumbnails'
            //     );
            // }

            return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            \Log::error("Category creation error: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Return the form to edit the category
     */
    public function edit($id)
    {
        try {
            $id = jsdecode_userdata($id);
            if (empty($id)) {
                return redirect()->back()->with('error', 'Invalid category ID.');
            }
            $category = Category::findOrFail($id);
            $categories = Category::all();
            return view('admin.category.edit', compact('category', 'categories'));
        } catch (\Exception $e) {
            \Log::info("Category Form edit error");
            return redirect()->back();
        }
    }

    /**
     * Update the specified category in storage.
     *
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $id = jsdecode_userdata($id);
            if (empty($id)) {
                return redirect()->back()->with('error', 'Invalid category ID.');
            }
            $category = Category::findOrFail($id);
            // $category->update($request->validated());
            $data = $request->validated();

            if ($request->hasFile('category_image')) {
                if ($category->cat_img_path) {
                    delete_image($category->cat_img_path);
                }
                $categoryImagePath = store_image($request->file('category_image'), 'category_images');
                $data['cat_img_path'] = $categoryImagePath['url'] ?? null; 
            }

            $category->update($data);

            //  if ($request->hasFile('category_image')) {
            //     $this->thumbnailService->generateThumbnails(
            //         $request->file('category_image'),
            //         $category,
            //         [
            //             'small' => [100, 100],
            //             'medium' => [300, 200],
            //             'large' => [800, 600],
            //         ],
            //         'category_thumbnails'
            //     );
            // }

            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            \Log::info("Category update error");
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     *
     */
    public function destroy($id)
    {
        try {
            $id = jsdecode_userdata($id);
            if (empty($id)) {
                return redirect()->back()->with('error', 'Invalid category ID.');
            }
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            \Log::info("Category delete error");
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Apply the specfic acction on category
     */

    public function applyCategory(Request $request)
    {

        try {
            $request->validate([
                'perform_action' => 'required|in:ACTIVE,INACTIVE',
                'category_ids' => 'required|array',
                'category_ids.*' => 'exists:categories,id',
            ]);

            $action = $request->perform_action;
            $categoryIds = $request->category_ids;
            DB::beginTransaction();

            Category::whereIn('id', $categoryIds)->update(['status' => $action]);

            DB::commit();
            $query = Category::query();
            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $categories = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            return response()->json([
                'html' => view('components.category-list', compact('categories'))->render(),
                'status' => true,
                'data' => [],
                'message' => 'Category status updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::info("Category status update error" . $e->getMessage());
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Failed to update category status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
