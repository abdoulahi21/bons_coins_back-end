<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Type\Time;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function saveimage($image,$path='public/images')
    {
       if( $image = null){
           return null;
       }
       $fileName=Time().'[.png,.jpg,.jpeg,.gif,.svg,.webp]';
       Storage::disk($path)->put($fileName,base64_decode($image));
       return URL::to('/').'/storage/images/'.$fileName;
    }
}
