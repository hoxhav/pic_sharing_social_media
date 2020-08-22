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

    protected $user;

    public function __construct()
    {
        $this->user = $this->getAuthenticatedUser()->getData();
    }

    /**
     * @return array
     */
    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {

                return  response()
                    ->json(
                        [
                            "response" => 404,
                            "data" => "User was not found."]
                    );

            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()
                ->json(
                    ["response" => 404,
                        "data" => "Your token session has expired. Please login again."]
                );

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()
                ->json(
                    ["response" => 404,
                        "data" => "Your token is invalid"]
                );

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()
                ->json(
                    ["response" => 404,
                        "data" => "Something went wrong."]
                );

        }

        return response()
            ->json(
                [ "response" => 200,
                    "data" => $user]
            );
    }
}
