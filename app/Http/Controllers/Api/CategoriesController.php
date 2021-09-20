<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::with('parent')
            ->when($request->query('parent_id'), function($query, $value) {
                $query->where('parent_id', '=', $value);
            })
            ->paginate();

        //return CategoryResource::collection($categories);
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$user = Auth::guard('sanctum')->user();
        
        if (!$request->user()->tokenCan('categories.create')) {
            abort(403, 'Not allowed');
        }

        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|int|exists:categories,id',
        ]);

        $category = Category::create($request->all());
        $category->refresh(); // SELECT * FROM categories WHERE id = ?

        //return $category;

        //return response()->json($category, 201);

        /*return Response::json($category, 201, [
            'x-application-name' => config('app.name'),
        ]);*/

        return new JsonResponse($category, 201, [
            'x-application-name' => config('app.name'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::with('children')->findOrFail($id);
        // if (!$category) {
        //     return Response::json([
        //         'message' => 'Not Found',
        //     ], 404);
        // }
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required',
            'parent_id' => 'nullable|int|exists:categories,id',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return Response::json([
            'message' => 'Category updated',
            'category' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return Response::json([
            'message' => 'Category deleted',
        ]);
    }
}
