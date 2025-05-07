<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CloudService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CloudServiceController extends Controller
{
  public function index()
  {
    try {
      $services = CloudService::all();

      if ($services->isEmpty()) {
        return response()->json([
          'mensaje' => 'No se encontraron servicios cloud registrados',
          'data' => []
        ], 200);
      }

      return response()->json([
        'mensaje' => 'Servicios cloud recuperados exitosamente',
        'data' => $services
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar los servicios cloud',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'provider' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string|max:50',
        'configuration' => 'nullable|array'
      ], [
        'required' => 'El campo :attribute es obligatorio',
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'array' => 'El campo :attribute debe ser un arreglo'
      ]);

      $service = CloudService::create($validated);

      return response()->json([
        'mensaje' => 'Servicio cloud creado exitosamente',
        'data' => $service
      ], 201);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al crear el servicio cloud',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show(string $id)
  {
    try {
      $service = CloudService::findOrFail($id);

      return response()->json([
        'mensaje' => 'Servicio cloud recuperado exitosamente',
        'data' => $service
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El servicio cloud no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar el servicio cloud',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function update(Request $request, string $id)
  {
    try {
      $service = CloudService::findOrFail($id);

      $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'provider' => 'sometimes|string|max:255',
        'type' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
        'status' => 'sometimes|string|max:50',
        'configuration' => 'nullable|array'
      ], [
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'array' => 'El campo :attribute debe ser un arreglo'
      ]);

      $service->update($validated);

      return response()->json([
        'mensaje' => 'Servicio cloud actualizado exitosamente',
        'data' => $service
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El servicio cloud no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al actualizar el servicio cloud',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function destroy(string $id)
  {
    try {
      $service = CloudService::findOrFail($id);
      $service->delete();

      return response()->json([
        'mensaje' => 'Servicio cloud eliminado exitosamente'
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El servicio cloud no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al eliminar el servicio cloud',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
