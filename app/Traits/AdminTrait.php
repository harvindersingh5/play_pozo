<?php
namespace App\Traits;

use App\Models\User;
use Exception;

trait AdminTrait {
    public function getUsers($request, $roleName) {
        try {
            $query = User::excludeAdmins()->role($roleName);
            if ($request->has('search') && !empty($request->search)) {
                $query->search($request->search);
            }

            if ($request->has('status')) {
                $query->status($request->status);
            }

            $paginationNumber = $request->input('paginationNumber', config('constant.pagination_number'));
            $users = $query->orderBy('id', 'DESC')->paginate($paginationNumber);

            return $users;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}