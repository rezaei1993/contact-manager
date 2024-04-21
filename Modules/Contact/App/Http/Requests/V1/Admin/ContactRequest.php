<?php

namespace Modules\Contact\App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'email' => 'required|email|unique:contacts,email,' . ($this->contact ? $this->contact->id : ''),
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
