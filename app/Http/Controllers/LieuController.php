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
            return response([
                'places'=> Place::orderBy('created_at', 'desc')->withCount('opinions','likes')->get()
                ],200);
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
            'latitude' => 'required|numeric|between:-90,90|regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/',
            'longitude' => 'required|numeric|between:-180,180|regex:/^[-]?((1[0-7][0-9])\.(\d+))|(180(\.0+)?)$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        // Si une image est fournie, la stocker

        try {
            $fileName = null;
            if ($request->hasFile('image')) {
                $fileName = time() . '.' . $request->image->extension();
                $request->image->storeAs('public/images', $fileName);
            }

            $lieu = new Place();
            $lieu->name = $request->name;
            $lieu->address = $request->address;
            $lieu->phone = $request->phone;
            $lieu->description = $request->description;
            $lieu-> image = $fileName;
            $lieu->category = $request->category;
            $lieu->latitude = $request->latitude;
            $lieu->longitude = $request->longitude;
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
