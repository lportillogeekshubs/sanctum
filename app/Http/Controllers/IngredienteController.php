<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class IngredienteController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = Ingrediente::all();

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
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) return $this->errorResponse('Validation Error->' . $validator->errors()->__toString());

        $result = Ingrediente::create($request->all());

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
        $result = Ingrediente::findOrFail($id);
        $result->platos;

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
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->fill($request->toArray());

        $result = $ingrediente->save();

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
        $ingrediente = Ingrediente::findOrFail($id);

        $result = $ingrediente->delete();

        return $this->successResponse($result, Response::HTTP_OK);
    }
}
