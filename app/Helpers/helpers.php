<?php

use App\Models\Country;
use App\Models\MediaUrl;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

if (!function_exists('encrypt_userdata')) {
    function encrypt_userdata(string $data)
    {
        try {
            $encryptData = Crypt::encryptString($data);
            return $encryptData;
        } catch (\Exception $e) {
            abort('403');
        }
    }
}
if (!function_exists('decrypt_userdata')) {
    function decrypt_userdata(string $data)
    {
        try {
            $decryptData = Crypt::decryptString($data);
            return $decryptData;
        } catch (\Exception $e) {
            abort('403');
        }
    }
}

if (!function_exists('jsencode_userdata')) {
    function jsencode_userdata($data, ?string $encryptionMethod = null, ?string $secret = null)
    {
        if (empty($data)) {
            return "";
        }
        $encryptionMethod = config('app.encryptionMethod');
        $secret = config('app.secrect');
        try {
            $iv = substr($secret, 0, 16);
            $jsencodeUserdata = str_replace('/', '!', openssl_encrypt($data, $encryptionMethod, $secret, 0, $iv));
            $jsencodeUserdata = str_replace('+', '~', $jsencodeUserdata);
            return $jsencodeUserdata;
        } catch (\Exception $e) {
            return null;
        }
    }
}
if (!function_exists('jsdecode_userdata')) {
    function jsdecode_userdata($data, ?string $encryptionMethod = null, ?string $secret = null)
    {
        if (empty($data))
            return null;
        $encryptionMethod = config('app.encryptionMethod');
        $secret = config('app.secrect');
        try {
            $iv = substr($secret, 0, 16);
            $data = str_replace('!', '/', $data);
            $data = str_replace('~', '+', $data);
            $jsencodeUserdata = openssl_decrypt($data, $encryptionMethod, $secret, 0, $iv);
            return $jsencodeUserdata;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('get_gender')) {
    function get_gender()
    {
        return ['Male', 'Female', 'Other'];
    }
}

if (!function_exists('get_status')) {
    function get_status()
    {
        return ['ACTIVE', 'Pending', 'Suspended'];
    }
}

// Store image
if (!function_exists('store_image')) {
    function store_image($data, string $path)
    {
        if (empty($data)) {
            return null;
        }
        try {
            $file = $data->getClientOriginalName();
            // $url = Storage::put($path, $data);
            $url = $data->store($path, 'public');
            return ['name' => $file, 'url' => $url];
        } catch (\Exception $e) {
            return null;
        }
    }
}

// Delete image
if (!function_exists('delete_image')) {
    function delete_image($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

if (!function_exists('get_countries')) {
    function get_countries()
    {
        $countries = Country::all();
        if ($countries->isEmpty()) {
            return [];
        }
        return $countries;
    }
}


if (!function_exists('getFormattedThumbnailSizes')) {
    function getFormattedThumbnailSizes($sizes)
    {

        if (empty($sizes) || !is_array($sizes)) {
            return [];
        }

        $transformedArray = [];

        foreach ($sizes as $item) {
            $name = $item['name'];
            $width = (int)$item['width'];
            $height = (int)$item['height'];
            $transformedArray[$name] = [$width, $height];
        }
        return $transformedArray;
    }
}

if (!function_exists('isSubadmin2FAEnabled')) {
    function isSubadmin2FAEnabled()
    {
        $setting =  DB::table('settings')
            ->where('key', 'two_factor_enabled')
            ->first();
        return json_decode($setting->value) === 'ACTIVE' ? true : false;

    }
}


/***
 * ************************************** laravel errors before middleware ***********************************************
 */
// Standard JSON response builder
if (!function_exists('apiError')) {
    function apiError($message, $error, $status = 500, array $extra = [])
    {
        return response()->json(array_merge([
            'status'  => false,
            'message' => $message,
            'error'   => $error,
        ], $extra), $status);
    }
}
if (!function_exists('sanctumErrorMessage')) {
    function sanctumErrorMessage($e)
    {
        // If exception is authentication related
        return match (true) {
            $e instanceof \Illuminate\Auth\AuthenticationException =>
                'Unauthenticated. Please provide a valid API token.',

            $e instanceof \Illuminate\Auth\Access\AuthorizationException =>
                'You are not authorized to access this resource.',

            default => $e->getMessage(),
        };
    }
}

// Safely determine appropriate HTTP status
if (!function_exists('guessStatus')) {
    function guessStatus($e)
    {
        if (method_exists($e, 'getStatusCode')) {
            $status = $e->getStatusCode();
            return ($status >= 100 && $status < 600) ? $status : 500;
        }
        return 500;
    }
}