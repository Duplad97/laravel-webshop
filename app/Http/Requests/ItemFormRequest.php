<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Ezzel lehet tiltani a requestet
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Szabályok
        return [
            'name' => 'required|min:4',
            'description' => 'required|min:12',
            'price' => 'required|min:1|max:100',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:4096',
        ];
    }

    // '(Mező.)szabály' => 'Egyéni üzenet'
    // A szabályokat angolul megtalálod itt: resources/lang/en/validation.php
    public function messages() {
        return [
            'name.required' => 'A név megadása kötelező',
            'description.required' => 'A leírás megadása kötelező',
            'price.required' => 'Az ár megadása kötelező',
            'name.min' => 'A név legalább :min karakter legyen',
            'description.min' => 'A leírás legalább :min karakter legyen',
            'price.min' => 'Az árnak 1 és 100 € között kell lennie',
            'price.max' => 'Az árnak 1 és 100 € között kell lennie'
            //'title.min' => 'A cím legalább :min karakter legyen',
        ];
    }
}
