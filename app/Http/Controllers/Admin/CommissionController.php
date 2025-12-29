<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
use Illuminate\Support\Facades\Log;

class CommissionController extends Controller
{
    /**
     * Display a listing of the commissions.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function listCommissions(Request $request)
    {
        try {
            $query = Commission::query();

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $commissions = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.commission-list', compact('commissions'))->render(),
                ]);
            }

            return view('admin.commission.index', compact('commissions'));
        } catch (\Exception $e) {
            Log::error('Error in listCommissions: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching commissions.');
        }
    }

    /**
     * Show the form for editing the specified commission.
     *
     * @param Commission $commission
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showEditForm(Commission $commission)
    {
        try {
            return view('admin.commission.edit', compact('commission'));
        } catch (\Exception $e) {
            Log::error('Error in showEditForm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the edit form.');
        }
    }

    /**
     * Update the specified commission in storage.
     *
     * @param Request $request
     * @param Commission $commission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCommission(Request $request, Commission $commission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:FLAT,PERCENTAGE',
            'value' => 'required|numeric|min:0',
        ]);

        try {
            $commission->update($request->only(['name', 'type', 'value']));
            return redirect()->route('admin.commission.index')->with('success', 'Commission updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error in updateCommission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the commission.');
        }
    }
}
