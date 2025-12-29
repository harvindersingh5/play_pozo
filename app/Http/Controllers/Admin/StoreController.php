<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
   public function index(Request $request)
    {
       try {
            $query = Store::with('vendor');


            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->has('status')) {
                if ($request->status != 'All') {
                    $query->status($request->status);
                }
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $stores = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.store-list', compact('stores'))->render(),
                ]);
            }

            // Return view for non-AJAX requests
            return view('admin.store.index', compact('stores'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $vendores = User::role('Vendor')->get();
        return view('admin.store.create' ,compact('vendores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required',
            'location' => 'nullable'
        ]);

        Store::create([
            'user_id' => $request->vendore_id ,
            'store_name' => $request->store_name,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.store.index')->with('success', 'Store created!');
    }

    public function edit(Store $store)
    {
        $this->authorizeStore($store);
        $store = $store->with('vendor')->first();
        $vendores = User::role('Vendor')->get();
        return view('admin.store.edit', compact('store' , 'vendores'));
    }

    public function update(Request $request, Store $store)
    {
        $this->authorizeStore($store);

        $request->validate([
            'store_name' => 'required',
            'location' => 'nullable',
        ]);
      
        $store->update($request->only(['store_name', 'location']));

        return redirect()->route('admin.store.index')->with('success', 'Store updated!');
    }

    public function destroy(Store $store)
    {
        $this->authorizeStore($store);

        $store->delete();

        return redirect()->route('admin.store.index')->with('success', 'Store deleted!');
    }

    private function authorizeStore(Store $store)
    {
        if (Auth::user()->hasRole('Vendor') && $store->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
