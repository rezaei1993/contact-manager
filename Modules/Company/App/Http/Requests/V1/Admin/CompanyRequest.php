<?php

namespace Modules\Company\App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' . ($this->company ? $this->company->id : ''),
            'phone' => 'required|string|max:20',
        ];
    }
}
