<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\Plato;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PlatoController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = Plato::all();

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
            'id_tipo_plato' => 'required|numeric',
            'nombre' => 'required|string|max:255',
            'comensales' => 'required|numeric',
        ]);

        if ($validator->fails()) return $this->errorResponse('Validation Error->' . $validator->errors()->__toString());

        $result = Plato::create($request->all());

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
        $result = Plato::findOrFail($id);
        $result->tipoPlato;
        $result->ingredientes;

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
        $plato = Plato::findOrFail($id);
        $plato->fill($request->toArray());

        $result = $plato->save();

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
        $plato = Plato::findOrFail($id);

        $result = $plato->delete();

        return $this->successResponse($result, Response::HTTP_OK);
    }
}
