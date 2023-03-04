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

    public function index(User $user): Response{
        return $this->successResponse($user->exams()->with('therapy')->get(),200,'Consulta de Examenes correcta');
    }

    public function store(Request $request): Response{

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

    public function usersExam(): Response {
       $user = User::findOrFail(1);
       $users = $user->therapies()->with('exams.user')
            ->get()
            ->pluck('exams')
            ->flatMap(function ($exams) {
                return $exams->pluck('user');
            })
            ->unique()->values()
           ->toArray();


        return $this->successResponse($users,200,'Usuarios de los Examenes');

    }

    public function allUsers(): Response{
        $user = User::findOrFail(auth()->user()->id);

        $usersWithExams = $user->therapies()->with('exams.user')->get()
            ->unique();

        return $this->successResponse($usersWithExams,200,'Usuarios de los Examenes');

    }
}
