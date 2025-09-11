<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Biography;
use Illuminate\Http\Request;

class BiographyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $biographies = Biography::latest()->get();
            return response()->json([
                'success' => true,
                'data' => $biographies,
                'count' => $biographies->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Biography $biography)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $biography
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Biographie non trouvée : ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
