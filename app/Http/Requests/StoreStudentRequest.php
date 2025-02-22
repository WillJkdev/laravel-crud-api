<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_names' => 'required|max:255',
            'phone' => 'required|digits_between:6,10',
            'math' => 'required|integer|min:0|max:100',
            'physics' => 'required|integer|min:0|max:100',
            'chemistry' => 'required|integer|min:0|max:100',
            'grade' => 'required|in:A,A+,B,B+,C,D,F',
            'comment' => 'required|string|max:500',
            'student_address' => 'required|string|max:255',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error al crear el estudiante.',
            'errors' => $validator->errors(),
            'status' => 422
        ], 422));
    }
}
