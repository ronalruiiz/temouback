<?php

namespace App\Http\Controllers;

use App\Models\Therapy;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TherapyController extends Controller
{
    use ResponseHelper;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $userid = auth()->user()->id;
        return $this->successResponse(Therapy::where('user_id','=', $userid)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        //Validated
        $validateTherapy = Validator::make($request->all(), [
            'name'=>'required',
            'visibility'=>'required|boolean',
            'description'=>'required',
            'expiration'=>'required|date'
        ]);

        if ($validateTherapy->fails()) {
            return $this->validationFailed($validateTherapy->errors(),'Campos incorrectos');
        }
        $userid = auth()->user()->id;
        $request->request->add(['user_id'=> $userid]);
        $therapy = Therapy::create($request->all());

        return $this->successResponse($therapy,200,"Terapía creada correctamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  Therapy  $therapy
     * @return Response
     */
    public function show(Therapy $therapy): Response
    {
        if($therapy->visibility){
            return $this->successResponse($therapy);
        }
        return $this->errorResponse(['La Terapia es privada']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Therapy  $therapy
     * @return Response
     */
    public function update(Request $request, Therapy $therapy)
    {
        //Validated
        $validateTherapy = Validator::make($request->all(), [
            'name'=>'required',
            'user_id'=>'required|exists:users,id',
            'expiration'=>'required|date'
        ]);

        if ($validateTherapy->fails()) {
            return response([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateTherapy->errors()
            ], 500);
        }

        Therapy::updated($request->all());

        return response([
            'status' => true,
            'message' => 'Therapy create successful'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
