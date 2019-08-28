<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterFormRequest extends FormRequest
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
    public function rules() {
        $id = $this->id;
        //$id = $this->route('id');
        return [
            'name' => 'required|min:2|max:255',
            'surname' => 'required|min:2|max:255',
            'address' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'cp' => 'required|min:2|max:5',
            'telephone' => 'required|min:2|max:20',
            'email' => 'required|min:6|max:255|unique:register_users,email,' . $id,
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 450));
    }
}
