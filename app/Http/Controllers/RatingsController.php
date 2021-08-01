<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Profile;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    public function store(Request $request, $type)
    {
        $request->validate([
            'rating' => 'required|int|min:1|max:5',
            'id' => 'required|int',
        ]);

        if ($type == 'product') {
            $model = Product::find($request->post('id'));
        } else if ($type == 'profile') {
            $model = Profile::find($request->post('id'));
        }

        $rating = $model->ratings()->create([
            'rating' => $request->post('rating'),
        ]);

        /*$rating = Rating::create([
            'rateable_type' => Profile::class,
            'rateable_id' => $request->post('id'),
            'rating' => $request->post('rating'),
        ]);*/

        return $rating;
    }
}
