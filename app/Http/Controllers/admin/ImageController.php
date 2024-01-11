<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Image;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        $image->delete();
        return back();
    }
}
