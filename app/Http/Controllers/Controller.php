<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * TODO: to fix it
     * @return array
     */
    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {

                return array(
                    "response" => 404,
                    "data" => "User was not found."
                );

            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return array(
                "response" => 404,
                "data" => "Your token session has expired. Please login again."
            );

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return array(
                "response" => 404,
                "data" => "Your token is invalid"
            );

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return array(
                "response" => 404,
                "data" => "Something went wrong."
            );

        }

        return array(
            "response" => 200,
            "data" => $user
        );
    }
}
