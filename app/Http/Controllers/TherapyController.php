<?php

namespace App\Http\Controllers;

use App\Models\Therapy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TherapyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response([
            'status' => true,
            'message' => Therapy::get(),
        ], 200);
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

        $therapy = Therapy::create($request->all());

        return response([
            'status' => true,
            'message' => $therapy
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Therapy  $therapy
     * @return Response
     */
    public function show(Therapy $therapy): Response
    {
        return response([
            'status' => true,
            'message' => $therapy,
        ], 200);
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
