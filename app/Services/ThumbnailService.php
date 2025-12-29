<?php

namespace App\Services;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\UploadedFile;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ThumbnailService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate thumbnails for an uploaded image
     *
     * @param UploadedFile $image The uploaded image file
     * @param mixed $model The model to associate thumbnails with
     * @param array $sizes Array of thumbnail sizes [name => [width, height]]
     * @param string $path Storage path for thumbnails
     * @return void
     */
    public function generateThumbnails1(UploadedFile $image, $model, array $sizes, string $path = 'uploads'): void
    {
        // Read the original image using the new API
        $originalImage = Image::read($image);
        $originalFileName = $image->hashName();
        $originalFileExtension = $image->getClientOriginalExtension();

        // Ensure the directory exists
        Storage::disk('public')->makeDirectory($path);

        // Generate thumbnails for each specified size
        foreach ($sizes as $name => [$width, $height]) {
            // Clone the image and resize it
            // The new API uses cover() or coverDown() instead of fit()
            $thumbnail = clone $originalImage;
            // crop
            // $thumbnail->fit($width, $height);  // This crops the image to fit the exact dimensions
            // cover
            // $thumbnail->cover($width, $height);  // This maintains aspect ratio and covers the entire area
            // resize 
            $thumbnail->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // scale
            // $thumbnail->scale($width, $height);  // This scales the image to the exact dimensions

            $thumbnailFileName = "{$originalFileName}_{$name}.{$originalFileExtension}";
            $thumbnailPath = $path . '/' . $thumbnailFileName;

            // Save the thumbnail - note the change from stream() to encode()
            Storage::disk('public')->put($thumbnailPath, $thumbnail->encode());

            // Create a Thumbnail model record
            $model->thumbnails()->create([
                // 'url' => Storage::url($thumbnailPath),
                'url' => $thumbnailPath,
                'name' => $name,
            ]);
        }

        // // Save original image
        // $originalImagePath = $path . '/' . $originalFileName . '.' . $originalFileExtension;
        // Storage::disk('public')->put($originalImagePath, $originalImage->encode());

        // Update the model with the original image path
        // $model->image_path = Storage::url($originalImagePath);
        // $model->save();
    }


    public function generateThumbnails(UploadedFile $image, Model $model, array $sizes, string $path = 'uploads'): void
    {
        // 1. Retrieve WebP Conversion Settings
        $convertToWebp = (bool) Setting::getSetting('convert_to_webp', false); // Default to false
        $webpQuality = (int) Setting::getSetting('webp_quality', 80);        // Default to 80

        // Ensure quality is within a valid range for WebP (0-100)
        $webpQuality = max(0, min(100, $webpQuality));


        // Read the original image
        $originalImage = Image::read($image);
        $originalFileNameWithoutExt = pathinfo($image->hashName(), PATHINFO_FILENAME);
        $originalFileExtension = $image->getClientOriginalExtension();

        // Determine the output extension and MIME type
        $outputExtension = $convertToWebp ? 'webp' : $originalFileExtension;
        $outputMime = $convertToWebp ? 'image/webp' : $originalImage->origin()->mediaType();


        // Ensure the storage directory exists
        Storage::disk('public')->makeDirectory($path);

        $settingThumbnailSizes = Setting::getSetting('thumbnail_sizes', []);

        if($settingThumbnailSizes){
            $sizes = getFormattedThumbnailSizes($settingThumbnailSizes);
        } else {
            $sizes = [
                'small' => [100, 100],
                'medium' => [300, 300],
                'large' => [600, 600],
            ];
        }


        // Generate thumbnails for each specified size
        foreach ($sizes as $name => [$width, $height]) {
            // Clone the original image for each thumbnail to avoid modifying the original
            $thumbnail = clone $originalImage;

            // Resize the thumbnail
            $thumbnail->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio(); // Maintain aspect ratio
                $constraint->upsize();      // Prevent upsizing images smaller than target dimensions
            });

            // Construct the thumbnail file name with the determined output extension
            $thumbnailFileName = "{$originalFileNameWithoutExt}_{$name}.{$outputExtension}";
            $thumbnailPath = $path . '/' . $thumbnailFileName;

            // Encode and save the thumbnail based on conversion settings
            if ($convertToWebp) {
                // Encode to WebP with the specified quality
                Storage::disk('public')->put($thumbnailPath, $thumbnail->toWebp($webpQuality));
            } else {
                // Encode to original format (or default JPEG/PNG if not specified)
                // You can add quality control for original formats here too if needed
                Storage::disk('public')->put($thumbnailPath, $thumbnail->encodeByExtension($originalFileExtension));
            }

            // Create a Thumbnail model record
            $model->thumbnails()->create([
                'url' => $thumbnailPath,
                'name' => $name,
                'extension' => $outputExtension, // Store the actual extension used
                // You might also want to store quality if it varies per thumbnail type
            ]);
        }

        // Handle saving the original image with conversion settings if desired
        // If you want the original uploaded image itself to be converted/optimized
        // before storing, you'd add similar logic here.
        // For example:
       /*
        $originalImagePath = $path . '/' . $originalFileNameWithoutExt . '.' . $outputExtension;
        if ($convertToWebp) {
            Storage::disk('public')->put($originalImagePath, $originalImage->toWebp($webpQuality));
        } else {
            Storage::disk('public')->put($originalImagePath, $originalImage->encodeByExtension($originalFileExtension));
        }
        $model->image_path = $originalImagePath; // Or whatever column stores the original image path
        $model->save();
        */
    }
}
