<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;
use App\Models\Student;

class studentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit', 50);
        $students = Student::paginate($perPage);

        if ($students->total() === 0) { // Verificar si no hay registros en la BD
            return response()->json([
                'message' => 'No hay estudiantes registrados',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'students' => $students,
            'status' => 200
        ], 200);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json([
            'message' => 'Estudiante creado correctamente',
            'student' => $student,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $student->delete();
        $data = [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(StoreStudentRequest $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $student->update($request->validated());
        return response()->json([
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ], 200);
    }

    public function updatePartial(UpdateStudentRequest $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->fill($request->only([
                'student_names',
                'phone',
                'math',
                'physics',
                'chemistry',
                'grade',
                'comment',
                'student_address'
            ]))->save();

            return response()->json([
                'message' => 'Estudiante actualizado parcialmente',
                'student' => $student,
                'status' => 200
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ], 404);
        }
    }
}
