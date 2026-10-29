<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function state(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'authenticated' => $user !== null,
            'favorites' => $user
                ? DB::table('favorites')
                    ->where('user_id', $user->id)
                    ->pluck('property_id')
                    ->map(fn ($id) => (int) $id)
                    ->values()
                    ->all()
                : [],
        ])->header('Cache-Control', 'private, no-store');
    }

    public function store(Request $request, Property $property)
    {
        abort_unless($property->status === 'Disponible', 404);

        DB::table('favorites')->insertOrIgnore([
            'user_id' => $request->user()->id,
            'property_id' => $property->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'saved' => true,
            'property_id' => $property->id,
        ]);
    }

    public function destroy(Request $request, Property $property)
    {
        DB::table('favorites')
            ->where('user_id', $request->user()->id)
            ->where('property_id', $property->id)
            ->delete();

        return response()->json([
            'saved' => false,
            'property_id' => $property->id,
        ]);
    }
}