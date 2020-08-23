<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $categories = Category::all();

        return response()->json([
            "success" => true,
            "data" => $categories
        ], 200);
    }

    /**
     * Search by category
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterByCategory(Request $request) {
        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $validator = Validator::make($request->all(), [

            'category_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $images = Image::with('tag', 'category')->where('category_id', $request->input('category_id'))->get();

        return response()->json([
            "success" => true,
            "data" => $images
        ], 200);
    }

    /**
     * Bookmark
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $category = new Category();

            $category->name = $request->input('name');

            $category->save();

        } catch(\Illuminate\Database\QueryException $ex){

            return  response()->json([
                "success" => false,
                "data" => "Something went wrong with your query."
            ], 200);

            //log $ex->getMessage()
        }

        return response()->json([
            "success" => true,
            "data" => $category
        ], 200);
    }

}
