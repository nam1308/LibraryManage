<?php

namespace App\Traits;

use App\Enums\TaxAdvisor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileTrait
{
    /**
     * @param $file
     * @param $path
     * @return String
     */
    public function upload($file, $path)
    {
        return Storage::putFile($path, $file, 'public');
    }

    /**
     * @param array $images
     * @return bool
     */
    public function delete($images = [])
    {
        return Storage::delete($images);
    }

    /**
     * @param $path
     * @return bool
     */
    public function exists($path)
    {
        return Storage::exists($path);
    }

    /**
     * @param $path
     * @param $file
     * @return String
     */
    public function storeFile($path, $file)
    {
        return Storage::put($path, $file, 'public');
    }

    /**
     * save image by Base64 code
     *
     * @param $base64Image
     * @param $user
     * @return String
     */
    public function saveBase64Image($base64Image, $path)
    {
        $base64Image = trim($base64Image);
        $search = substr($base64Image, 0, strpos($base64Image, ",") + 1);
        $base64Image = str_replace($search, '', $base64Image);
        $base64Image = str_replace(' ', '+', $base64Image);

        // base64 decode image
        $imageData = base64_decode($base64Image);

        // get image extension
        $imageExtension = substr($search, strpos($search, "/") + 1, strpos($search, ";") - (strpos($search, "/") + 1));
        $filePath = $path . '/' . time() . '_' . Str::random(4) . '.' . $imageExtension;

        Storage::put(
            $filePath,
            $imageData
        );
        return $filePath;
    }

    /**
     * Save video
     *
     * @param $file
     * @return array
     */
    public function saveVideo($file, $path, $nameOriginal = true): array
    {
        if (empty($file)) {
            return [
                'link' => null,
                'file_name' => null,
            ];
        }

        // Get image extension
        $fileName = time() . '_' . Str::random(4) . '_' . $file->getClientOriginalName();
        $filePath = $path . '/' . $fileName;

        Storage::put(
            $filePath,
            file_get_contents($file)
        );
        return [
            'link' => $filePath,
            'file_name' => $nameOriginal ? $file->getClientOriginalName() : $fileName,
        ];
    }
}
