<?php

namespace App\Traits;

use Illuminate\Http\Request;

use App\Models\User;

trait ResponseHelper
{
    public function validationFailed($input_errors, $message = null, $status_code = 400)
    {
        $errors = [];
        foreach ($input_errors->all() as $msg) {
            array_push($errors, $msg);
        }
        return $this->errorResponse($errors, $status_code, $message);
    }

    public function successResponse($data, $status_code = 200, $message = null)
    {
        $success = [
            "code"=> $status_code,
            "message"=> $message,
            "data"=> $data
        ];
        return response($success, $status_code);
    }

    public function errorResponse($errors, $status_code = 400, $message = null)
    {
        $error = [
            "code"=> $status_code,
            "message"=> $message,
            "data"=> null,
            "errors"=> $errors,
        ];
        return response($error, $status_code);
    }
}

