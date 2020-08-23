<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
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

        $images = Image::with('tag','category')->get();

        return response()->json([
            "success" => true,
            "data" => $images
        ], 200);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function listMyImages()
    {
        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $images = Image::with('category', 'tag')->where('user_id', $this->user->data->id)->get();

        return response()->json([
            "success" => true,
            "data" => $images
        ], 200);

    }

    /**
     * Third tasks, uploading picture
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request) {

        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }


        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'category_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $upload_path = public_path('assets/images/');
        $file_name = time().'.'.$request['image']->getClientOriginalName();
        $request['image']->move($upload_path, $file_name);

        $path = $upload_path . $file_name;

        try {

            $image = new Image();

            $image->name = $request->input('name');
            $image->path = $path;
            $image->user_id = $this->user->data->id;
            $image->category_id = $request->input('category_id');

            $image->save();

        } catch(\Illuminate\Database\QueryException $ex){

            return  response()->json([
                "success" => false,
                "data" => "Something went wrong with your query."
            ], 200);

            //log $ex->getMessage()
        }

        return response()->json([
            "success" => true,
            "data" => $image
        ], 200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request) {
        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $validator = Validator::make($request->all(), [

            'name_phrase' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //search by name image
        $images = Image::with('category','tag')
            ->where('name', 'like', '%'.$request->input('name_phrase').'%')
            ->get();

        //no result, search by tag
        if(count($images) === 0) {

            $images = Image::with('category', 'tag')
                ->whereHas('tag',function ($query) use ($request) {

                    $query->where('name', 'like', '%'.$request->input('name_phrase').'%');

                })
                ->get();

        }

        return response()->json([
            "success" => true,
            "data" => $images
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function download(Request $request) {

        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }

        $validator = Validator::make($request->all(), [

            'id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $image = Image::select('path')->where('id', $request->input('id'))->get();

        return response()->download($image[0]['path']);
    }

}
