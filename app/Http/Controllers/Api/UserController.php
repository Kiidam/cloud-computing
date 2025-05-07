<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
  public function index()
  {
    try {
      $users = User::all();

      if ($users->isEmpty()) {
        return response()->json([
          'mensaje' => 'No se encontraron usuarios registrados',
          'data' => []
        ], 200);
      }

      return response()->json([
        'mensaje' => 'Usuarios recuperados exitosamente',
        'data' => $users
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar los usuarios',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8'
      ], [
        'required' => 'El campo :attribute es obligatorio',
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'min' => 'El campo :attribute debe tener al menos :min caracteres',
        'email' => 'El campo :attribute debe ser un correo electrónico válido',
        'unique' => 'El :attribute ya está registrado'
      ]);

      $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password'])
      ]);

      return response()->json([
        'mensaje' => 'Usuario creado exitosamente',
        'data' => $user
      ], 201);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al crear el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show(string $id)
  {
    try {
      $user = User::findOrFail($id);

      return response()->json([
        'mensaje' => 'Usuario recuperado exitosamente',
        'data' => $user
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El usuario no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al recuperar el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function update(Request $request, string $id)
  {
    try {
      $user = User::findOrFail($id);

      $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
        'password' => 'sometimes|string|min:8'
      ], [
        'string' => 'El campo :attribute debe ser texto',
        'max' => 'El campo :attribute no debe exceder :max caracteres',
        'min' => 'El campo :attribute debe tener al menos :min caracteres',
        'email' => 'El campo :attribute debe ser un correo electrónico válido',
        'unique' => 'El :attribute ya está registrado'
      ]);

      if (isset($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
      }

      $user->update($validated);

      return response()->json([
        'mensaje' => 'Usuario actualizado exitosamente',
        'data' => $user
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El usuario no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (ValidationException $e) {
      return response()->json([
        'mensaje' => 'Error de validación',
        'errores' => $e->errors()
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al actualizar el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function destroy(string $id)
  {
    try {
      $user = User::findOrFail($id);
      $user->delete();

      return response()->json([
        'mensaje' => 'Usuario eliminado exitosamente'
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'mensaje' => 'El usuario no existe',
        'error' => 'No se encontró el registro con ID: ' . $id
      ], 404);
    } catch (\Exception $e) {
      return response()->json([
        'mensaje' => 'Error al eliminar el usuario',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
