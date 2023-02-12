<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Traits\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    use ResponseHelper;
    public function register(Request $request): Response{

        try {
            //Validated
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'questions' => 'json',
                'therapy_id' => 'exists:therapies,id'
            ]);

            if ($validator->fails()) {
                return $this->validationFailed($validator->errors());
            }

            $user = User::firstOrCreate(['email' => $request->get('email')], ['name' => $request->get('name'),'role'=>'patient']);
            $request->request->add(['user_id'=> $user->id]);
            $examn = Exam::create($request->all());

            return $this->successResponse($examn,201,'Examen realizado correctamente');
        } catch (\Throwable $th) {
            return $this->errorResponse([$th->getMessage()]);
        }
    }
}
