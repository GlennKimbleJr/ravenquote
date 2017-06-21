<?php

namespace App\Http\Requests;

use App\Form\FieldTypes;
use App\Form\Types;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', Rule::in(Types::get())],
            
            'fields.*.name' => 'required',
            'fields.*.value' => 'required',
            'fields.*.final_value' => 'required',
            'fields.*.affects' => ['required','fieldCantAffectItself','fieldValidAffectOption'],
            'fields.*.type' => ['required', Rule::in(FieldTypes::get())],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'field_cant_affect_itself' => 'A field can not affect itself.',
            'field_valid_affect_option' => 'A field can only affect an existing field or the total.',
        ];
    }
}
