<?php

namespace Modules\Contact\App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BulkCreateContactNotesRequest extends FormRequest
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
            '*.content' => 'string',
        ];
    }
}
