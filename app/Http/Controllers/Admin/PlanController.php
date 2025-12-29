<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    private $stripeClient;

    public function __construct()
    {
        $stripeSecret = env('STRIPE_SECRET');
        if (!is_null($stripeSecret)) {
            $this->stripeClient = new StripeClient($stripeSecret);
        }
    }

    /**
     * Display a listing of the plans.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function listPlans(Request $request)
    {
        if (!is_null(config('services.pk_key'))) {
            // notify()->success('Please add the stripe details', 'Success');
            return redirect()->route('admin.dashboard')->with('error', 'Please add the stripe details');
        }

        try {

            $query = Plan::query();

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->has('status')) {
                if($request->status != 'All'){
                    $query->status($request->status);
                }
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $plans = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.plan-list', compact('plans'))->render(),
                ]);
            }

            return view('admin.plan.index', compact('plans'));
        } catch (\Exception $e) {
            Log::error('Error in listPlans: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching plans.');
        }
    }

    /**
     * Show the form for creating a new plan or editing an existing one.
     *
     * @param Plan|null $plan
     * @return \Illuminate\View\View
     */
    public function showPlanForm(Plan $plan = null)
    {
        return view('admin.plan.create', compact('plan'));
    }

    /**
     * Store a newly created plan or update an existing one in storage.
     *
     * @param Request $request
     * @param Plan|null $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savePlan(Request $request, Plan $plan = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'validity' => 'required|in:WEEKLY,MONTHLY,ANNUAL',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        try {
            $validity = $this->mapValidity($request->validity);
            $isActive = ($request->status == 'ACTIVE');

            if ($plan && $plan->exists) {
                $this->updateExistingPlan($plan, $request, $validity, $isActive);
            } else {
                $this->createNewPlan($request, $validity, $isActive);
            }

            return redirect()->route('admin.plan.index')->with('success', 'Plan saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error in savePlan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving the plan.');
        }
    }

    /**
     * Remove the specified plan from storage.
     *
     * @param Plan $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePlan(Plan $plan)
    {
        try {
            $plan->delete();
            return redirect()->route('admin.plan.index')->with('success', 'Plan deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error in deletePlan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the plan.');
        }
    }

    /**
     * Update the status of a specific plan.
     *
     * @param Request $request
     * @param Plan $plan
     * @return \Illuminate\Http\JsonResponse
     */
    public function togglePlanStatus(Request $request, Plan $plan)
    {
        try {
            $status = $request->input('status');
            $plan->update(['status' => $status]);
            return response()->json(['status' => $status, 'message' => 'Plan status updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Error in togglePlanStatus: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the plan status.'], 500);
        }
    }

    private function mapValidity($validity)
    {
        return [
            'ANNUAL' => 'year',
            'MONTHLY' => 'month',
            'WEEKLY' => 'week'
        ][$validity] ?? '';
    }

    private function updateExistingPlan(Plan $plan, Request $request, $validity, $isActive)
    {
        $product = $this->stripeClient->products->update($plan->stripe_id, [
            'name' => $request->name,
            'description' => $request->description,
            'active' => $isActive,
        ]);

        $price = $this->stripeClient->prices->create([
            'unit_amount' => (float)($request->price) * 100,
            'currency' => strtolower(env('STRIPE_CURRENCY') ?? 'usd'),
            'recurring' => ['interval' => $validity],
            'product' => $product->id,
        ]);

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'validity' => $request->validity,
            'description' => $request->description,
            'status' => $request->status,
            'stripe_id' => $product->id,
            'stripe_price' => $price->id,
        ]);
    }

    private function createNewPlan(Request $request, $validity, $isActive)
    {
        $product = $this->stripeClient->products->create([
            'name' => $request->name,
            'description' => $request->description,
            'active' => $isActive,
            'statement_descriptor' => env('STRIPE_SUBSCRIPTION_STATEMENT', 'Subscription'),
        ]);

        $price = $this->stripeClient->prices->create([
            'unit_amount' => (float)($request->price) * 100,
            'currency' => strtolower(env('STRIPE_CURRENCY') ?? 'usd'),
            'recurring' => ['interval' => $validity],
            'product' => $product->id,
        ]);

        Plan::create([
            'name' => $request->name,
            'price' => $request->price,
            'validity' => $request->validity,
            'description' => $request->description,
            'status' => $request->status,
            'stripe_id' => $product->id,
            'stripe_price' => $price->id,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'perform_action' => 'required|in:ACTIVE,INACTIVE',
            'plan_ids' => 'required|array',
            'plan_ids.*' => 'exists:plans,id',
        ]);

        $action = $request->perform_action;
        $planIds = $request->plan_ids;

        try {
            DB::beginTransaction();

            Plan::whereIn('id', $planIds)->update(['status' => $action]);
           
            DB::commit();
            $query = Plan::query();
            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $plans = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            return response()->json([
                'html' => view('components.plan-list', compact('plans'))->render(),
                'status' => true,
                'data' => [],
                'message' => 'Plan status updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Failed to update plan status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
