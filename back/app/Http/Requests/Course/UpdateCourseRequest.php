<?php

namespace App\Http\Requests\Course;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'sometimes|required|string|max:255',
            'description'=> 'nullable|string',
            'teacher_id' => 'sometimes|required|exists:users,id',
        ];
    }
}
