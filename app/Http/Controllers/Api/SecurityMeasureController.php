<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SecurityMeasure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class SecurityMeasureController extends Controller
{
  public function index()
  {
    try {
      $measures = SecurityMeasure::all();

      if ($measures->isEmpty()) {
        return response()->json([
          'mensaje' => 'No se encontraron medidas de seguridad registradas',
          'data' => []
        ], 200);
      }

      return response()->json([
        'mensaje' => 'Medidas de seguridad recuperadas exitosamente',
        'data' => $measures
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar las medidas de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|max:50',
        'settings' => 'nullable|array',
        'implementation_date' => 'required|date',
        'review_date' => 'nullable|date|after:implementation_date'
      ], [
        'required' => 'El campo :attribute es obligatorio',
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'array' => 'El campo :attribute debe ser un arreglo',
        'date' => 'El campo :attribute debe ser una fecha válida',
        'after' => 'La fecha de revisión debe ser posterior a la fecha de implementación'
      ]);

      $measure = SecurityMeasure::create($validated);

      return response()->json([
        'mensaje' => 'Medida de seguridad creada exitosamente',
        'data' => $measure
      ], 201);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al crear la medida de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show(string $id)
  {
    try {
      $measure = SecurityMeasure::findOrFail($id);

      return response()->json([
        'mensaje' => 'Medida de seguridad recuperada exitosamente',
        'data' => $measure
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'La medida de seguridad no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar la medida de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function update(Request $request, string $id)
  {
    try {
      $measure = SecurityMeasure::findOrFail($id);

      $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'type' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'status' => 'sometimes|string|max:50',
        'settings' => 'nullable|array',
        'implementation_date' => 'sometimes|date',
        'review_date' => 'nullable|date|after:implementation_date'
      ], [
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'array' => 'El campo :attribute debe ser un arreglo',
        'date' => 'El campo :attribute debe ser una fecha válida',
        'after' => 'La fecha de revisión debe ser posterior a la fecha de implementación'
      ]);

      $measure->update($validated);

      return response()->json([
        'mensaje' => 'Medida de seguridad actualizada exitosamente',
        'data' => $measure
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'La medida de seguridad no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al actualizar la medida de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function destroy(string $id)
  {
    try {
      $measure = SecurityMeasure::findOrFail($id);
      $measure->delete();

      return response()->json([
        'mensaje' => 'Medida de seguridad eliminada exitosamente'
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'La medida de seguridad no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al eliminar la medida de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
