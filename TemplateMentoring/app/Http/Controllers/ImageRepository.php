<?php
namespace App\Http\Controllers;
use Dropbox\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Storage;
class ImageRepository extends Controller
{
public function saveImage($image)
    {
        if (!is_null($image))
        {
            $file = $image;
            $extension = $image->getClientOriginalExtension();
            $fileName = time() . random_int(100, 999) .'.' . $extension; 
            $destinationPath = public_path('images/especialistas/');
            $url = 'images/especialistas/'.$fileName;
            $fullPath = $destinationPath.$fileName;
            $image = Image::make($file)->encode('jpg');
            $image->save($fullPath, 100);
            return $fileName;
        } else {
            return 'http://'.$_SERVER['HTTP_HOST'].' /images/'.'/placeholder300x300.jpg';
        }
    }
    
    public function apagarImages($foto)
    {
        if(file_exists(public_path($foto))){
            unlink(public_path($foto));
        }
    }
}