<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{

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
            'tags' => 'required|string|max:255',
            'category_id' => 'required|integer',

       ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $upload_path = public_path('assets/images/');
        $file_name = time().'.'.$request['image']->getClientOriginalName();
        $request['image']->move($upload_path, $file_name);

        $path = $upload_path . $file_name;

        $image = new Image();

        $image->name = $request->input('name');
        $image->path = $path;
        $image->tags = $request->input('tags');
        $image->user_id = $this->user->data->id;
        $image->category_id = $request->input('category_id');

        $image->save();

        return response()->json([
            "success" => true,
            "data" => $image
        ], 200);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Image::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
