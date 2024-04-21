<?php

namespace Modules\Contact\App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
