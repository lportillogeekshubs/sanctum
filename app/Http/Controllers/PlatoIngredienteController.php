<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\PlatoIngrediente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PlatoIngredienteController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = PlatoIngrediente::all();

        return $this->successResponse($result, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_plato' => 'required|numeric',
            'id_ingrediente' => 'required|numeric',
            'cantidad' => 'required|numeric',
        ]);

        if ($validator->fails()) return $this->errorResponse('Validation Error->' . $validator->errors()->__toString());

        $result = PlatoIngrediente::create($request->all());

        return $this->successResponse($result, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = PlatoIngrediente::findOrFail($id)->ingrediente;

        return $this->successResponse($result, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $platoIngrediente = PlatoIngrediente::findOrFail($id);
        $platoIngrediente->fill($request->toArray());

        $result = $platoIngrediente->save();

        return $this->successResponse($result, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $platoIngrediente = PlatoIngrediente::findOrFail($id);

        $result = $platoIngrediente->delete();

        return $this->successResponse($result, Response::HTTP_OK);
    }
}
