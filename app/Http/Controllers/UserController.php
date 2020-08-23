<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use JWTAuth;

class UserController extends Controller
{


    /**
     * Task: User can update email, and name.
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if($this->user->response !== 200) {
            return response()->json([
                "success" => false,
                "data" => $this->user->data
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $user =  User::find($this->user->data->id);


        $update_data = array(

            'name'  => $request->input('name'),
            'email'  => $request->input('email'),
        );


        $user->update($update_data);

        return response()->json([
            "success" => true,
            "data" => $user
        ], 200);


    }

}
