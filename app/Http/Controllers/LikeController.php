<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Place;
use App\Models\User;
use App\Models\Opinion;
class LikeController extends Controller
{
    //
    public function likeOrUnLike($id)
    {
        $place = Place::find($id);
        if (!$place) {
            return response()->json([
                'message' => 'Place not found',
            ], 404);
        }
        $like =$place->likes()->where('user_id', auth()->user()->id)->first();
        if ($like) {
            $like->delete();
            return response()->json([
                'message' => 'Like removed',
            ], 200);
        }
        Like::create([
            'user_id' => auth()->user()->id,
            'place_id' => $id,
        ]);
        return response()->json([
            'message' => 'Liked',
        ], 200);
    }
}
