<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SecurityIncident;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class SecurityIncidentController extends Controller
{
  public function index()
  {
    try {
      $incidents = SecurityIncident::with('cloudService')->get();

      if ($incidents->isEmpty()) {
        return response()->json([
          'mensaje' => 'No se encontraron incidentes de seguridad registrados',
          'data' => []
        ], 200);
      }

      return response()->json([
        'mensaje' => 'Incidentes de seguridad recuperados exitosamente',
        'data' => $incidents
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar los incidentes de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'severity' => 'required|string|in:low,medium,high,critical',
        'status' => 'required|string|in:open,investigating,resolved,closed',
        'cloud_service_id' => 'nullable|exists:cloud_services,id',
        'detected_at' => 'required|date',
        'resolved_at' => 'nullable|date|after:detected_at',
        'affected_resources' => 'nullable|array',
        'resolution_steps' => 'nullable|array'
      ], [
        'required' => 'El campo :attribute es obligatorio',
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'in' => 'El valor seleccionado para :attribute no es válido',
        'date' => 'El campo :attribute debe ser una fecha válida',
        'after' => 'La fecha de resolución debe ser posterior a la fecha de detección',
        'exists' => 'El servicio cloud seleccionado no existe'
      ]);

      $incident = SecurityIncident::create($validated);

      return response()->json([
        'mensaje' => 'Incidente de seguridad creado exitosamente',
        'data' => $incident
      ], 201);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al crear el incidente de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show(string $id)
  {
    try {
      $incident = SecurityIncident::with('cloudService')->findOrFail($id);

      return response()->json([
        'mensaje' => 'Incidente de seguridad recuperado exitosamente',
        'data' => $incident
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El incidente de seguridad no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar el incidente de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function update(Request $request, string $id)
  {
    try {
      $incident = SecurityIncident::findOrFail($id);

      $validated = $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'severity' => 'sometimes|string|in:low,medium,high,critical',
        'status' => 'sometimes|string|in:open,investigating,resolved,closed',
        'cloud_service_id' => 'nullable|exists:cloud_services,id',
        'detected_at' => 'sometimes|date',
        'resolved_at' => 'nullable|date|after:detected_at',
        'affected_resources' => 'nullable|array',
        'resolution_steps' => 'nullable|array'
      ], [
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'in' => 'El valor seleccionado para :attribute no es válido',
        'date' => 'El campo :attribute debe ser una fecha válida',
        'after' => 'La fecha de resolución debe ser posterior a la fecha de detección',
        'exists' => 'El servicio cloud seleccionado no existe'
      ]);

      $incident->update($validated);

      return response()->json([
        'mensaje' => 'Incidente de seguridad actualizado exitosamente',
        'data' => $incident
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El incidente de seguridad no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al actualizar el incidente de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function destroy(string $id)
  {
    try {
      $incident = SecurityIncident::findOrFail($id);
      $incident->delete();

      return response()->json([
        'mensaje' => 'Incidente de seguridad eliminado exitosamente'
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El incidente de seguridad no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al eliminar el incidente de seguridad',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
