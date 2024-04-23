<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller\api;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()){
            $user = auth::user();
            $restaurants = Restaurant::where('user_id', $user->id)->get();
            return response()->json($restaurants);
        } else {
            return response()->json([], 401); 
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'horaires_ouverture' => 'required|string|max:255',
                'image_illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $restaurant = Restaurant::create([
                'nom'=> $validated ['nom'],
                'adresse' => $validated ['adresse'],
                'horaires_ouverture' => $validated ['horaires_ouverture'],
                'image_illustration' => $validated ['image_illustration'],
                'user_id' => $user_id
            ]);
            $restaurant->user_id = $user_id;
            if ($request->hasFile('image_illustration')) {
                $path = $request->file('image_illustration')->store('public/restaurants');
                $restaurant->image_illustration = str_replace('public/', 'storage/', $path);
            }

            $restaurant->save();

            return response()->json(['message' => 'Restaurant créé avec succès.', 'restaurant' => $restaurant], 201);
        } else {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            return response()->json($restaurant);
        } else {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $id)
    {

        if(Auth::check()) {
            $user_id = Auth::id();
        
        $validator = Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:255',   
            'adresse' => 'sometimes|required|string|max:255',
            'horaires_ouverture' => 'sometimes|required|string|max:255',
            'image_illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }

        $restaurant->update($request->only(['nom', 'adresse', 'horaires']));

        if ($request->hasFile('image_illustration')) {
            $path = $request->file('image_illustration')->store('public/restaurants');
            $restaurant->image_illustration = str_replace('public/', 'storage/', $path);
        }

        $restaurant->save();
        return response()->json(['message' => 'Restaurant mis à jour avec succès.', 'restaurant' => $restaurant], 200);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->delete();
            return response()->json(['message' => 'Restaurant supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Restaurant non trouvé'], 404);
        }
    }
}
