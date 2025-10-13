<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObrRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set to true to allow anyone to make this request.
        // Or implement your authorization logic here.
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
            'request_id' => 'required|exists:pao_requests,id',
            'obr_no' => 'required|string|unique:obr_request,obr_no',
            'office_address' => 'nullable|string|max:255',
            'obr_objects' => 'required|array',
            'obr_objects.*.object_expenditure_id' => 'required|integer|exists:object_expenditures,id', // Assuming you have an 'object_expenditures' table
            'obr_objects.*.amount' => 'required|numeric|min:0',
        ];
    }
}