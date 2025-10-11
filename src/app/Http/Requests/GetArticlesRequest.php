<?php

namespace App\Http\Requests;

use App\Enums\NewsSource;
use App\Services\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetArticlesRequest extends FormRequest
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
        $sources = NewsSource::casesNames()->join(',');
        return [
            'source'        => ['nullable', 'string', 'in:'. $sources],
            'category'      => ['nullable', 'string'],
            'author'        => ['nullable', 'string'],
            'from_date'     => ['nullable', 'date', 'date_format:Y-m-d'],
            'to_date'       => ['nullable', 'date', 'date_format:Y-m-d'],
            'keyword'       => ['nullable', 'string'],
            'per_page'      => ['nullable', 'integer', 'min:20', 'max:100'],
            'cursor'        => ['nullable', 'string'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::failedValidation($validator));
    }
}
