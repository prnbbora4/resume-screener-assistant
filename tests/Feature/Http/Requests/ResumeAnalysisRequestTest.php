<?php

use App\Http\Requests\HistoryFilterRequest;
use App\Http\Requests\StoreResumeAnalysisRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\Validator;

function validateFormRequest(FormRequest $request, array $data): Validator
{
    $request->merge($data);

    $validator = app(ValidatorFactory::class)->make(
        $request->all(),
        $request->rules(),
        $request->messages(),
        $request->attributes(),
    );

    if (method_exists($request, 'after')) {
        foreach ($request->after() as $callback) {
            $validator->after($callback);
        }
    }

    return $validator;
}

test('store resume analysis request accepts valid input and is authorized', function () {
    $request = new StoreResumeAnalysisRequest;
    $validator = validateFormRequest($request, [
        'candidate_name' => 'Jordan Rivera',
        'job_description' => str_repeat('Role description ', 4),
        'resume' => str_repeat('Candidate experience ', 4),
    ]);

    expect($request->authorize())->toBeTrue()
        ->and($validator->passes())->toBeTrue();
});

test('store resume analysis request rejects missing and invalid length input', function () {
    $request = new StoreResumeAnalysisRequest;
    $validator = validateFormRequest($request, [
        'candidate_name' => str_repeat('a', 256),
        'job_description' => 'Too short',
        'resume' => str_repeat('r', 30001),
    ]);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('candidate_name'))->toBeTrue()
        ->and($validator->errors()->has('job_description'))->toBeTrue()
        ->and($validator->errors()->has('resume'))->toBeTrue();
});

test('store resume analysis request requires all submitted fields', function () {
    $request = new StoreResumeAnalysisRequest;
    $validator = validateFormRequest($request, []);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('candidate_name'))->toBeTrue()
        ->and($validator->errors()->has('job_description'))->toBeTrue()
        ->and($validator->errors()->has('resume'))->toBeTrue();
});

test('history filter request accepts query filters and is authorized', function () {
    $request = HistoryFilterRequest::create('/history?search=Jordan&min_score=50&max_score=90', 'GET');
    $validator = validateFormRequest($request, $request->query());

    expect($request->authorize())->toBeTrue()
        ->and($validator->passes())->toBeTrue();
});

test('history filter request rejects out of range values and reversed score range', function () {
    $request = HistoryFilterRequest::create('/history', 'GET');
    $validator = validateFormRequest($request, [
        'search' => str_repeat('a', 256),
        'min_score' => 80,
        'max_score' => 40,
    ]);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('search'))->toBeTrue()
        ->and($validator->errors()->has('min_score'))->toBeTrue();
});
