<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaperTrailSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Or your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Get the model instance for updates. Assumes route parameter is 'paperTrailSet'
        $paperTrailSet = $this->route('paperTrailSet');

        return [
            'set_no' => [
                // For 'update' (PUT/PATCH), set_no is required and must be unique, ignoring itself.
                Rule::when($this->isMethod('POST'), [
                    'required',
                    'integer'
                ])
            ],
            'office_code' => ['required', 'string', 'max:255'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.office_code_step_owner' => ['required', 'string', 'max:255'],
            'steps.*.internal_steps' => ['required', 'array', 'min:1'],
            'steps.*.internal_steps.*.approval_title' => ['required', 'string', 'max:255'],
        ];
    }
}