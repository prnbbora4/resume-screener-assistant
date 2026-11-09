<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreResumeAnalysisRequest extends FormRequest
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
            'candidate_name' => ['required', 'string', 'max:255'],
            'job_description' => ['required', 'string', 'min:50', 'max:20000'],
            'resume' => ['required', 'string', 'min:50', 'max:30000'],
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
            'candidate_name.required' => 'Please enter the candidate’s name.',
            'candidate_name.string' => 'The candidate name must be text.',
            'candidate_name.max' => 'The candidate name may not be longer than 255 characters.',
            'job_description.required' => 'Please enter the job description.',
            'job_description.string' => 'The job description must be text.',
            'job_description.min' => 'The job description must be at least 50 characters.',
            'job_description.max' => 'The job description may not be longer than 20,000 characters.',
            'resume.required' => 'Please enter the candidate’s resume.',
            'resume.string' => 'The candidate resume must be text.',
            'resume.min' => 'The candidate resume must be at least 50 characters.',
            'resume.max' => 'The candidate resume may not be longer than 30,000 characters.',
        ];
    }

    /**
     * Keep submitted resume and job text out of the session on validation redirects.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            parent::failedValidation($validator);
        }

        throw new HttpResponseException(
            redirect()->back()
                ->withInput($this->only('candidate_name'))
                ->withErrors($validator),
        );
    }
}
