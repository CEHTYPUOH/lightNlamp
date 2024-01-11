<?php

namespace App\Http;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function upload($files, $folder = '/', $product, $default = '')
    {
        foreach ($files as $file){
            if ($file != null) {
                $path = $file->store($folder, 'public');
            } else {
                $path = $default;
            }
            Image::create(['product_id' => $product, 'url' => url("/storage/" . $path)]);
        }
    }

    public static function delete($images)
    {
        foreach ($images as $image){
            $path = '/public/products/' . pathinfo($image->url, PATHINFO_BASENAME);
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }
    }

    public static function update($file, $newFile, $folder = '/', $product)
    {
        $delete = FileService::delete($file);
        $upload = FileService::upload($newFile, $folder, $product);
        return [$delete, $upload];
    }
}
