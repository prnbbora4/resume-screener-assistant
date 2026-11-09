<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class HistoryFilterRequest extends FormRequest
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
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'min_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'max_score' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    /**
     * Validate the score range after individual field rules pass.
     *
     * @return array<int, \Closure(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $minimum = $this->input('min_score');
                $maximum = $this->input('max_score');

                if (
                    is_numeric($minimum)
                    && is_numeric($maximum)
                    && (int) $minimum > (int) $maximum
                    && ! $validator->errors()->hasAny(['min_score', 'max_score'])
                ) {
                    $validator->errors()->add(
                        'min_score',
                        'The minimum score must be less than or equal to the maximum score.',
                    );
                }
            },
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'search.string' => 'The candidate search must be text.',
            'search.max' => 'The candidate search may not be longer than 255 characters.',
            'min_score.integer' => 'The minimum score must be a whole number.',
            'min_score.min' => 'The minimum score must be at least 0.',
            'min_score.max' => 'The minimum score may not be greater than 100.',
            'max_score.integer' => 'The maximum score must be a whole number.',
            'max_score.min' => 'The maximum score must be at least 0.',
            'max_score.max' => 'The maximum score may not be greater than 100.',
        ];
    }
}
