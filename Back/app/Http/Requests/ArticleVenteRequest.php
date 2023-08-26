<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleVenteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "libelle"=>"bail|required|unique:article_ventes",
            // 'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "ref"=>"required",
            "prix_vente"=>"bail|required|numeric|min:2",
            "qte_stock"=>"bail|required|numeric|min:0",
            "cout_fabrication"=>"bail|required|numeric|min:1",
            "marge_article"=>"bail|required|numeric|min:1",

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => $validator->errors()->first(),
                'data' => [],
                "success"=>Response::HTTP_OK
            ])
        );
    }
}
