<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function indexThumbnailSize()
    {
        // Get current settings
        $settings = Setting::getSetting('thumbnail_sizes', []);
        $convertToWebp = Setting::getSetting('convert_to_webp', false);
        $webpQuality = Setting::getSetting('webp_quality', 80);

        return view('admin.settings.thumbnail.index', compact(
            'settings',
            'convertToWebp',
            'webpQuality'
        ));
    }

    public function createThumbnailSize()
    {
        return view('admin.settings.thumbnail.create');
    }


    public function storeThumbnailSize(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'width' => 'required|integer|min:1',
                'height' => 'required|integer|min:1',
            ]);

            $thumbnailSizes = Setting::getSetting('thumbnail_sizes', []);

            $thumbnailSizes[] = [
                'name' => $request->name,
                'width' => $request->width,
                'height' => $request->height,
            ];

            Setting::setSetting('thumbnail_sizes', $thumbnailSizes);

            return redirect()->route('admin.settings.thumbnail.index')
                ->with('success', 'Thumbnail size added successfully.');
        } catch (\Exception $e) {
            \Log::error("Thumbnail size creation error: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function editThumbnailSize($index)
    {
        try {
            $thumbnailSizes = Setting::getSetting('thumbnail_sizes', []);

            if (isset($thumbnailSizes[$index])) {
                $setting = $thumbnailSizes[$index];
                return view('admin.settings.thumbnail.edit', compact('setting', 'index'));
            }
            return redirect()->route('admin.settings.thumbnail.index')
                ->with('error', 'Invalid thumbnail size index.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateThumbnailSize(Request $request, $index)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'width' => 'required|integer|min:1',
                'height' => 'required|integer|min:1',
            ]);

            $thumbnailSizes = Setting::getSetting('thumbnail_sizes', []);

            if (isset($thumbnailSizes[$index])) {
                $thumbnailSizes[$index] = [
                    'name' => $request->name,
                    'width' => $request->width,
                    'height' => $request->height,
                ];
                Setting::setSetting('thumbnail_sizes', $thumbnailSizes);
            }


            return redirect()->route('admin.settings.thumbnail.index')
                ->with('success', 'Thumbnail size updated successfully.');
        } catch (\Exception $e) {
            \Log::error("Thumbnail size updation error: " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function deleteThumbnailSize($index)
    {
        try {
            $thumbnailSizes = Setting::getSetting('thumbnail_sizes', []);

            if (isset($thumbnailSizes[$index])) {
                array_splice($thumbnailSizes, $index, 1);
                Setting::setSetting('thumbnail_sizes', $thumbnailSizes);

                return redirect()->route('admin.settings.thumbnail.index')
                    ->with('success', 'Thumbnail size removed successfully.');
            }

            return redirect()->route('admin.settings.thumbnail.index')
                ->with('error', 'Thumbnail size not found.');
        } catch (\Exception $e) {
            \Log::error('Error in deleteSize: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the size.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'convert_to_webp' => 'boolean',
            'webp_quality' => 'integer|min:1|max:100',
            'thumbnail_sizes' => 'array',
            'thumbnail_sizes.*.name' => 'required|string',
            'thumbnail_sizes.*.width' => 'required|integer|min:1',
            'thumbnail_sizes.*.height' => 'required|integer|min:1',
        ]);

        // Save thumbnail sizes
        Setting::setSetting('thumbnail_sizes', $request->thumbnail_sizes);

        // Save webp conversion settings
        Setting::setSetting('convert_to_webp', $request->convert_to_webp);
        Setting::setSetting('webp_quality', $request->webp_quality);

        return redirect()->route('admin.settings.thumbnail.index')
            ->with('success', 'Image settings updated successfully.');
    }


    public function indexImageConversion(Request $request)
    {
        $convertToWebp = Setting::getSetting('convert_to_webp', false);
        return view('admin.settings.convert-to-webp', compact('convertToWebp'));
    }


    public function storeImageConversion(Request $request)
    {
        try {
            $request->validate([
                'convert_to_webp' => 'required|in:true,false',
            ]);

            $valueToStore = $request->input('convert_to_webp');

            Setting::setSetting('convert_to_webp', $valueToStore);

            return redirect()->route('admin.settings.image-conversion.index')->with('success', 'Image conversion setting updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error("Image conversion setting update error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating settings: ' . $e->getMessage());
        }
    }


    public function updateImageConversion(Request $request)
    {
        try {
            $request->validate([
                'convert_to_webp' => 'required|boolean',
            ]);

            $convertToWebp = $request->input('convert_to_webp');

            Setting::setSetting('convert_to_webp', $convertToWebp);

            return response()->json([
                'status' => true,
                'message' => 'Image conversion setting updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors()),
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Image conversion setting update error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating settings: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function indexWebpQuality(Request $request)
    {
        $webpQuality = Setting::getSetting('webp_quality', 80);
        return view('admin.settings.webp-quality', compact('webpQuality'));
    }

    public function storeWebpQuality(Request $request)
    {
        try {
            $request->validate([
                'webp_quality' => 'required|in:70,75,80,85,90,95,100',
            ]);

            $valueToStore = $request->input('webp_quality');

            Setting::setSetting('webp_quality', $valueToStore);

            return redirect()->route('admin.settings.webp-quality.index')->with('success', 'Webp quality setting updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error("Webp quality setting update error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating settings: ' . $e->getMessage());
        }
    }


    public function updateWebpQuality(Request $request)
    {
        try {
            $request->validate([
                'webp_quality' => 'required|integer|min:1|max:100',
            ]);

            $webpQuality = $request->input('webp_quality');

            Setting::setSetting('webp_quality', $webpQuality);

            return response()->json([
                'status' => true,
                'message' => 'Webp quality setting updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors()),
            ], 422);
        } catch (\Exception $e) {
            \Log::error("Webp quality setting update error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating settings: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function indexWebsiteSettings(Request $request)
    {
        $logo = Setting::getSetting('logo', '');
        $favicon = Setting::getSetting('favicon', '');
        $website_name = Setting::getSetting('website_name', '');
        return view('admin.settings.website-settings', [
            'logo' => $logo,
            'favicon' => $favicon,
            'website_name' => $website_name,
        ]);
    }

    public function storeWebsiteSettings(Request $request)
    {
        try {
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'favicon' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'website_name' => 'required|string|min:2|max:50',
            ]);

            if ($request->hasFile('logo')) {
                $logo = Setting::getSetting('logo', '');
                if ($logo) {
                    delete_image($logo);
                }
                $logoUploaded = store_image($request->file('logo'), 'logo');
                $logoPath = $logoUploaded['url'] ?? null;
            }

            if ($request->hasFile('favicon')) {
                $favicon = Setting::getSetting('favicon', '');
                if ($favicon) {
                    delete_image($favicon);
                }
                $faviconUploaded = store_image($request->file('favicon'), 'favicon');
                $faviconPath = $faviconUploaded['url'] ?? null;
            }

            Setting::setSetting('logo', $logoPath);
            Setting::setSetting('favicon', $faviconPath);
            Setting::setSetting('website_name', $request->website_name);

            return redirect()->route('admin.settings.website.index')->with('success', 'Website settings updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error("Website settings update error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating website settings: ' . $e->getMessage());
        }
    }

    public function indexSmtpDetails(Request $request)
    {
        $smtp_details = Setting::getSetting('smtp_details', '');
        return view('admin.settings.smpt-details', compact('smtp_details'));
    }

    public function storeSmtpDetails(Request $request)
    {
        try {
            $request->validate([
                'smtp_host' => 'required|string',
                'smtp_port' => 'required|integer|min:1|max:65535',
                'smtp_username' => 'required|string',
                'smtp_password' => 'required|string',
                'smtp_encryption' => 'nullable|in:tls,ssl',
                'mail_from_address' => 'required|email',
                'mail_from_name' => 'required|string',
            ]);

            $smtpSettings = [
                'host' => $request->smtp_host,
                'port' => $request->smtp_port,
                'username' => $request->smtp_username,
                'password' => encrypt($request->smtp_password),
                'encryption' => $request->smtp_encryption,
                'from_address' => $request->mail_from_address,
                'from_name' => $request->mail_from_name,
            ];

            Setting::setSetting('smpt_details', $smtpSettings);

            return redirect()->route('admin.settings.smtp_details.index')->with('success', 'SMTP details updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error("SMTP details update error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating SMTP details: ' . $e->getMessage());
        }
    }


    public function twoFactorCreate(Request $request)
    {
        $setting =Setting::where('key', 'two_factor_enabled')->first();
        return view('admin.settings.two_factor_enabled',compact('setting'));
    }

    public function twoFactorEnabled(Request $request)
    {
        try {
            $request->validate([
                'two_factor_enabled' => 'required',
            ]);

            $valueToStore = $request->input('two_factor_enabled');
            Setting::setSetting('two_factor_enabled', $valueToStore);

            return redirect()->route('admin.settings.two-factor-create')->with('success', 'Two Factor Authentication setting updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error("Two Factor Authentication setting update error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating settings: ' . $e->getMessage());
        }
    }
}
