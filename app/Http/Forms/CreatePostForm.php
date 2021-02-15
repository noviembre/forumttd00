<?php

namespace App\Http\Forms;

use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostForm extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => [ 'required', new SpamFree ],
        ];
    }
}
