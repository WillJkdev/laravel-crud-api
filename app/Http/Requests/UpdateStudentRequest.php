<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateStudentRequest extends FormRequest
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
            'student_names' => 'max:255',
            'phone' => 'digits_between:6,10',
            'math' => 'integer|min:0|max:100',
            'physics' => 'integer|min:0|max:100',
            'chemistry' => 'integer|min:0|max:100',
            'grade' => 'in:A,A+,B,B+,C,D,F',
            'comment' => 'string|max:500',
            'student_address' => 'string|max:255',
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
