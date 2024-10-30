<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Place;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //

        $places = Place::find($id);

        if (!$places) {
            return response()->json([
                'message' => 'Place not found',
            ], 404);
        }
        return response([
            'opinions' => $places->opinions()->with('user:id')->get(),
        ], 200);
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
    public function store(Request $request, $id)
    {
        //
        $places = Place::find($id);

        if (!$places) {
            return response()->json([
                'message' => 'Place not found',
            ], 404);
        }

        $request->validate([
            'comment' => 'required|string',
        ]);

            Opinion::create([
            'user_id' => auth()->user()->id,
            'comment' => $request->comment,
            'place_id' => $id,
        ]);
        return response([
            'message' => 'Opinion created successfully',
            'places' => $places->opinions()->with('user:id')->get(),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $opinion = Opinion::find($id);

        if (!$opinion) {
            return response()->json([
                'message' => 'opinion not found',
            ], 404);
        }
        if($opinion->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $validatedData = $request->validate([
            'comment' => 'required|string',
        ]);

        // Met à jour l'opinion avec les données validées
        $opinion->update($validatedData);

        return response([
            'message' => 'Opinion updated successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $opinion = Opinion::find($id);

        if (!$opinion) {
            return response()->json([
                'message' => 'opinion not found',
            ], 404);
        }

        if($opinion->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $opinion->delete();
        return response([
            'message' => 'Opinion deleted successfully',
        ], 200);
    }
}
