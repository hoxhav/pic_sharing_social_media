<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Validator;

class TagController extends Controller
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

        $tags = Tag::all();

        return response()->json([
            "success" => true,
            "data" => $tags
        ], 200);
    }

    public function listImageTags(Request $request) {

        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $validator = Validator::make($request->all(), [

            'image_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tags = Tag::where('image_id', $request->input('image_id'))->get();

        return response()->json([
            "success" => true,
            "data" => $tags
        ], 200);

    }

    /**
     * Search by category
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
            'image_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $tag = new Tag();

            $tag->name = $request->input('name');
            $tag->image_id = $request->input('image_id');

            $tag->save();

        } catch(\Illuminate\Database\QueryException $ex){

            return  response()->json([
                "success" => false,
                "data" => "Something went wrong with your query."
            ], 200);

            //log $ex->getMessage()
        }



        return response()->json([
            "success" => true,
            "data" => $tag
        ], 200);
    }

}
