<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class LieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $places = Place::all();
            return response()->json([
                'places' => $places->map(function($place) {
                    return [
                        'name' => $place->name,
                        'description' => $place->description,
                        'address' => $place->address,
                        'phone' => $place->phone,
                        'category' => $place->category,
                        'image'=>$place->image_url, // Utilisez l'URL complète
                        'latitude' => $place->latitude,
                        'longitude' => $place->longitude,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([$places,'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        //pour l'image
        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);
        try {
            $lieu = new Place();
            $lieu->name = $request->name;
            $lieu->address = $request->address;
            $lieu->phone = $request->phone;
            $lieu->description = $request->description;
            $lieu-> image = $fileName;
            $lieu->category = $request->category;
            $lieu->latitude = $request->latitude;
            $lieu->longitude = $request->longitude;
            //$lieu->number_opinions = $request->number_opinions;
            $lieu->save();
            return response()->json($lieu);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response([
            'place'=>Place::where('id',$id)->withCount('opinions','likes')->get()
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        //pour l'image
        $fileName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);
        try {
            $lieu = Place::find($id);
            $lieu->name = $request->name;
            $lieu->address = $request->address;
            $lieu->phone = $request->phone;
            $lieu->description = $request->description;
            $lieu-> image = $fileName;
            $lieu->category = $request->category;
            $lieu->latitude = $request->latitude;
            $lieu->longitude = $request->longitude;
            //$lieu->number_opinions = $request->number_opinions;
            $lieu->save();
            return response()->json($lieu);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $lieu = Place::find($id);
            $lieu->delete();
            return response()->json(['message' => 'Place deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
