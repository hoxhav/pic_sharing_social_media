<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Validator;

class BookmarkController extends Controller
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

        $bookmarks = Bookmark::with('image')->get();

        return response()->json([
            "success" => true,
            "data" => $bookmarks
        ], 200);
    }

    /**
     * Logged in user bookmarks
     * @return \Illuminate\Http\JsonResponse
     */
    public function userBookmarks() {

        if($this->user->response !== 200) {

            return response()->json([

                "success" => false,

                "data" => $this->user->data

            ], 404);

        }


        $bookmarks = Bookmark::with('image')->where('user_id', $this->user->data->id)->get();

        return response()->json([
            "success" => true,
            "data" => $bookmarks
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

            'image_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bookmark = new Bookmark();

        $bookmark->image_id = $request->input('image_id');
        $bookmark->user_id = $this->user->data->id;

        $bookmark->save();

        return response()->json([
            "success" => true,
            "data" => $bookmark
        ], 200);
    }

}
