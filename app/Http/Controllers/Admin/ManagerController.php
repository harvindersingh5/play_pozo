<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\{User, UserActivity, UserDetail};
use App\Traits\AdminTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash, Log, Mail, Storage};
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\{Permission, Role};
use Symfony\Component\HttpFoundation\StreamedResponse;

class ManagerController extends Controller
{
    use AdminTrait;

    /**
     * Display a listing of users.
     *
     */
    public function index(Request $request)
    {
        try {
            $roleName = config('constant.role.manager.name');
            $users = $this->getUsers($request, $roleName);

            // $users = $query->orderBy('id', 'DESC')->get();
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.user-list', compact('users'))->render(),
                ]);
            }

            // Return view for non-AJAX requests
            return view('admin.managers.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Return the form to create the user
     */

    public function create()
    {
        try {
            $roles = Role::whereNot('name', 'Administrator')->get();
            return view('admin.managers.create', compact('roles'));
        } catch (\Exception $e) {
            \Log::info("User Form creation error");
            return redirect()->back();
        }
    }

    /**
     * Create new user function
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'encrypt_password' => jsencode_userdata($request->password),
                'status' => $request->status,
            ]);

            $role = Role::findOrFail($request->input('role'));
            $user->assignRole($role);
            if ($role) {
                $permissions = $role->permissions->pluck('name')->toArray();
                $role->syncPermissions($permissions);
            }
            if ($request->hasFile('profile_picture')) {
                $profilePicPath = store_image($request->file('profile_picture'), 'profile_pictures');
            }
            if ($request->hasFile('back_picture')) {
                $backPicPath = store_image($request->file('back_picture'), 'background_pictures');
            }

            $userDetailsData = [
                'user_id' => $user->id,
                'gender' => $request->gender,
                'address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'pincode' => $request->postal_code,
                'profile_path' => $profilePicPath['url'] ?? null,
                'back_profile_path' => $backPicPath['url'] ?? null

            ];

            UserDetail::create($userDetailsData);

            DB::commit();

            return redirect()->route('admin.managers.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'User creation failed: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified user.
     * */
    public function edit($id)
    {
        try {
            $userId = jsdecode_userdata($id);
            $user = User::findOrFail($userId);
            $roles = Role::get();
            return view('admin.managers.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * This function is update the specfic user details
     */

    public function update(UserRequest $request, $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();

            $userId = jsdecode_userdata($id);
            $user = User::findOrFail($userId);

            $userData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'status' => $request->status,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
                $userData['encrypt_password'] = jsencode_userdata($request->password);
            }

            $user->update($userData);

            if ($request->filled('role')) {
                $role = Role::findOrFail($request->input('role'));
                $user->syncRoles([$role->name]);

                $permissions = $role->permissions->pluck('name')->toArray();
                $user->givePermissionTo($permissions);
            }


            $profilePicPath = ($user->user_detail) ? $user->user_detail->profile_path : null;
            $backPicPath = ($user->user_detail) ? $user->user_detail->back_profile_path : null;

            if ($request->hasFile('profile_picture')) {
                if ($user->user_detail && $user->user_detail->profile_path) {
                    Storage::disk('public')->delete($user->user_detail->profile_path);
                }

                $storeImgData = store_image($request->file('profile_picture'), 'profile_pictures');
                $profilePicPath = $storeImgData['url'] ?? null;
            }
            if ($request->hasFile('back_picture')) {
                if ($user->user_detail && $user->user_detail->back_profile_path) {
                    Storage::disk('public')->delete($user->user_detail->back_profile_path);
                }

                $storeBackPicData = store_image($request->file('back_picture'), 'background_pictures');
                $backPicPath = $storeBackPicData['url'] ?? null;
            }

            $userDetailsData = [
                'address' => $request->address,
                'gender' => $request->gender,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'pincode' => $request->postal_code,
                'profile_path' => $profilePicPath ?? null,
                'back_profile_path' => $backPicPath ?? null,
            ];

            UserDetail::updateOrCreate(
                ['user_id' => $user->id],
                $userDetailsData
            );

            DB::commit();

            return redirect()->route('admin.managers.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'User update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user record
     */

    public function destroy($id)
    {
        try {
            $userId = jsdecode_userdata($id);

            $user = User::findOrFail($userId);

            if (($user->user_detail && $user->user_detail->profile_path) || ($user->user_detail && $user->user_detail->back_profile_path)) {
                Storage::disk('public')->delete($user->user_detail->profile_path);
                Storage::disk('public')->delete($user->user_detail->back_profile_path);
            }
            $user->delete();
            return redirect()->route('admin.managers.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * View specfic user data
     */
    public function show($id)
    {
        try {
            $userId = jsdecode_userdata($id);
            $user = User::findOrFail($userId);
            $roles = Role::get();

            return view('admin.managers.show', compact('user', 'roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * suspend the user account
     */

    public function suspend($id)
    {
        try {
            $userId = jsdecode_userdata($id);
            $user = User::findOrFail($userId);

            $user->update([
                'status' => 'Suspended',
            ]);
            return redirect()->route('admin.managers.index')->with('success', 'User suspended successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Apply the specfic acction on user
     */

    public function applyUser(Request $request)
    {
        // Validate the request
        $request->validate([
            'perform_action' => 'required|in:Delete,ACTIVE,Suspended,Pending',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $action = $request->perform_action;
        $userIds = $request->user_ids;

        try {
            DB::beginTransaction();

            if ($action === 'Delete') {
                User::whereIn('id', $userIds)->each(function ($user) {
                    $user->delete();
                });
            } else {
                User::whereIn('id', $userIds)->update(['status' => $action]);
            }

            DB::commit();
            $query = User::excludeAdmins();
            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $users = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            return response()->json([
                'html' => view('components.user-list', compact('users'))->render(),
                'status' => true,
                'data' => [],
                'message' => 'User status updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Failed to update user status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Downlod user detsils csv format
     */

    public function downloadCSV()
    {
        try {
            $query = User::with(['user_detail.countryData', 'user_detail.stateData', 'user_detail.cityData'])
                ->excludeAdmins()
                ->get();

            $filename = 'users_' . now()->format('YmdHis') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($query) {
                $handle = fopen('php://output', 'w');

                // Add CSV header row
                fputcsv($handle, [
                    'ID',
                    'First Name',
                    'Last Name',
                    'Email',
                    'Status',
                    'Address',
                    'Country',
                    'State',
                    'City',
                    'Phone Number',
                    'Pincode',
                ]);

                // Add data rows
                foreach ($query as $user) {
                    $userDetail = $user->user_detail;
                    fputcsv($handle, [
                        $user->id,
                        $user->first_name ?? '',
                        $user->last_name ?? '',
                        $user->email ?? '',
                        $user->status ?? '',
                        $userDetail->address ?? '',
                        $userDetail?->country_name ?? '',
                        $userDetail?->state_name ?? '',
                        $userDetail?->city_name ?? '',
                        $userDetail?->phone_number ?? '',
                        $userDetail?->pincode ?? '',
                    ]);
                }

                fclose($handle);
            };

            return new StreamedResponse($callback, 200, $headers);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Failed to generate download. ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     *  here is the code for send the download cs file
     */

    public function shareCsv(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);
            $downloadLink = route('admin.users.download-csv');

            Mail::send('admin.emails.csv_download', ['downloadLink' => $downloadLink], function ($message) {
                $message->to('maximo@gmail.com')
                    ->subject('Download Your CSV File');
            });

            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Email send successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Failed to send download link. ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display a listing of sub-admin users.
     *
     * @return \Illuminate\View\View
     */
    public function subAdmin(Request $request)
    {
        try {
            $mainquery = User::query();

            $query = $mainquery->whereHas('roles', function ($que) {
                $que->where('name', 'Subadmin');
            });

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->has('status')) {
                $query->status($request->status);
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $users = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            // $users = $query->orderBy('id', 'DESC')->get();
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.user-list', compact('users'))->render(),
                ]);
            }

            return view('admin.subadmin.index', compact('users'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userActivity(Request $request)
    {
        try {
            $query = UserActivity::with('user')->where(function ($q) {
                $q->whereNull('user_id')
                    ->orWhere('user_id', '!=', 1);
            });

            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }
            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $logs = $query->orderBy('id', 'DESC')->paginate($paginationNumber);
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('components.user-activity-component', compact('logs'))->render(),
                ]);
            }

            return view('admin.user_activites', compact('logs'));
        } catch (\Exception $e) {
            Log::error('Error in listCommissions: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching commissions.');
        }
    }
}
