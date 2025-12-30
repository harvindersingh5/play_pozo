<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function toggleStatus(Request $request)
    {
        $id = jsdecode_userdata($request->id);
        try {
            $class = "App\Models\\{$request->model}";

            if (empty($class)) {
                return response()->json(['status' => 'error', 'message' => ucwords($request->model) . ' not found'], 404);
            }
            $result = $class::where('id', $id)->firstOrFail();
            $field = $request->input('field') ? $request->input('field') : 'status';

            // $statusField = $field ? $field : 'status';
            $status = ($result->$field === 'ACTIVE') ? 'Suspended' : 'ACTIVE';

            $model_msg = $request->message == 'hashtag' ? 'Hashtag' : ($request->model == 'CmsPage' ? 'CMS page' : ucwords($request->model));

            if ($result->update([$field => $status])) {
                if ($status == 'ACTIVE') {
                    return response()->json(['status' => 'success', 'message' => $model_msg . $this->getMsg($field, $status)], 200);
                } else {
                    return response()->json(['status' => 'danger', 'message' => $model_msg . $this->getMsg($field, $status)], 200);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => $model_msg . ' has not been updated.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }


    public function getMsg($field, $status)
    {
        $msg = "";
        switch ($field) {
            default:
                if ($status == '1') {
                    $msg = " has been activated";
                } else {
                    $msg = " has been deactivated";
                }
        }
        return $msg;
    }
}
