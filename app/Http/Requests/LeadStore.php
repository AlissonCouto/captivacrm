<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStore extends FormRequest
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
            'name' => 'required|min:3|max:100|regex:/[a-zA-Zà-úÀ-Ú\s]/',
            'phone' => 'nullable',
            'address' => 'nullable',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'lastContact' => 'nullable|date',
            'callScheduled' => 'nullable|date',
            'statusId' => 'required|integer|exists:statuses,id',
            'nicheId' => 'required|integer|exists:niches,id',
            'cityId' => 'required|exists:cities,id',
            'status' => 'required',
        ];
    }
}
