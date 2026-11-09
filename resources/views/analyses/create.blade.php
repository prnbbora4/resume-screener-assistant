<x-app-layout
    title="New Analysis"
    description="Compare a candidate's experience with your role requirements."
>
    <div class="mx-auto max-w-6xl">
        <x-page-heading
            title="New Resume Analysis"
            description="Share the role requirements and candidate resume to get a structured, AI-powered screening report."
        />

        @if ($errors->any())
            <x-alert type="error" class="mb-6">
                <span class="font-semibold">Please review the information below.</span>
                <ul class="mt-1 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <form
            action="{{ route('analyses.store') }}"
            method="POST"
            data-analysis-form
            data-min-job-description="50"
            data-max-job-description="20000"
            data-min-resume="50"
            data-max-resume="30000"
            class="space-y-6"
        >
            @csrf

            <section class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-sm shadow-gray-200/40 sm:p-7" aria-labelledby="candidate-heading">
                <div class="mb-5 flex items-center gap-3">
                    <span class="flex size-9 items-center justify-center rounded-xl bg-indigo-50 text-sm font-semibold text-indigo-700">01</span>
                    <div>
                        <h2 id="candidate-heading" class="text-base font-semibold text-gray-900">Candidate information</h2>
                        <p class="mt-0.5 text-sm text-gray-500">Start with the candidate's name.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    <label for="candidate_name" class="mb-2 block text-sm font-medium text-gray-700">
                        Candidate Name <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <input
                        id="candidate_name"
                        name="candidate_name"
                        type="text"
                        value="{{ old('candidate_name') }}"
                        placeholder="Enter candidate's full name"
                        maxlength="255"
                        autocomplete="name"
                        required
                        aria-required="true"
                        aria-invalid="{{ $errors->has('candidate_name') ? 'true' : 'false' }}"
                        @if ($errors->has('candidate_name')) aria-describedby="candidate-name-error" @endif
                        class="block min-h-12 w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 hover:border-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 aria-[invalid=true]:border-red-400"
                    >
                    @error('candidate_name')
                        <p id="candidate-name-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Use the name you'd like to see in the screening report.</p>
                </div>
            </section>

            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-2">
                <section class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-sm shadow-gray-200/40 sm:p-7" aria-labelledby="job-description-heading">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-indigo-50 text-sm font-semibold text-indigo-700">02</span>
                        <div>
                            <h2 id="job-description-heading" class="text-base font-semibold text-gray-900">Job description</h2>
                            <p class="mt-0.5 text-sm text-gray-500">What does success in this role look like?</p>
                        </div>
                    </div>

                    <label for="job_description" class="mb-2 block text-sm font-medium text-gray-700">
                        Job Description <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <textarea
                        id="job_description"
                        name="job_description"
                        rows="12"
                        minlength="50"
                        maxlength="20000"
                        required
                        aria-required="true"
                        aria-invalid="{{ $errors->has('job_description') ? 'true' : 'false' }}"
                        aria-describedby="job-description-help job-description-counter @if ($errors->has('job_description')) job-description-error @endif"
                        placeholder="Paste the job description here..."
                        data-counted-textarea
                        data-min-length="50"
                        data-max-length="20000"
                        class="block w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 hover:border-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 aria-[invalid=true]:border-red-400"
                    >{{ old('job_description') }}</textarea>
                    <div class="mt-2 flex flex-wrap items-center justify-between gap-2">
                        <p id="job-description-help" class="text-xs text-gray-500">At least 50 characters, up to 20,000.</p>
                        <button
                            type="button"
                            data-clear-textarea="job_description"
                            aria-label="Clear job description"
                            class="inline-flex min-h-9 items-center gap-1.5 rounded-lg px-2.5 text-xs font-semibold text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                        >
                            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 7h16M10 11v6m4-6v6M6.5 7l1 13h9l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Clear
                        </button>
                    </div>
                    <div class="mt-1 flex justify-end">
                        <p id="job-description-counter" data-character-counter="job_description" aria-live="polite" class="text-xs font-medium text-gray-400">0 / 20,000</p>
                    </div>
                    @error('job_description')
                        <p id="job-description-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </section>

                <section class="rounded-2xl border border-gray-200/80 bg-white p-5 shadow-sm shadow-gray-200/40 sm:p-7" aria-labelledby="resume-heading">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-indigo-50 text-sm font-semibold text-indigo-700">03</span>
                        <div>
                            <h2 id="resume-heading" class="text-base font-semibold text-gray-900">Candidate resume</h2>
                            <p class="mt-0.5 text-sm text-gray-500">Include the candidate's relevant experience and skills.</p>
                        </div>
                    </div>

                    <label for="resume" class="mb-2 block text-sm font-medium text-gray-700">
                        Candidate Resume <span class="text-red-600" aria-hidden="true">*</span>
                    </label>
                    <textarea
                        id="resume"
                        name="resume"
                        rows="12"
                        minlength="50"
                        maxlength="30000"
                        required
                        aria-required="true"
                        aria-invalid="{{ $errors->has('resume') ? 'true' : 'false' }}"
                        aria-describedby="resume-help resume-counter @if ($errors->has('resume')) resume-error @endif"
                        placeholder="Paste the candidate's resume here..."
                        data-counted-textarea
                        data-min-length="50"
                        data-max-length="30000"
                        class="block w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm outline-none transition placeholder:text-gray-400 hover:border-gray-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 aria-[invalid=true]:border-red-400"
                    >{{ old('resume') }}</textarea>
                    <div class="mt-2 flex flex-wrap items-center justify-between gap-2">
                        <p id="resume-help" class="text-xs text-gray-500">At least 50 characters, up to 30,000.</p>
                        <button
                            type="button"
                            data-clear-textarea="resume"
                            aria-label="Clear candidate resume"
                            class="inline-flex min-h-9 items-center gap-1.5 rounded-lg px-2.5 text-xs font-semibold text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                        >
                            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 7h16M10 11v6m4-6v6M6.5 7l1 13h9l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Clear
                        </button>
                    </div>
                    <div class="mt-1 flex justify-end">
                        <p id="resume-counter" data-character-counter="resume" aria-live="polite" class="text-xs font-medium text-gray-400">0 / 30,000</p>
                    </div>
                    @error('resume')
                        <p id="resume-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </section>
            </div>

            <section class="rounded-2xl border border-indigo-100 bg-indigo-50/60 p-5 sm:p-6" aria-labelledby="report-preview-heading">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                    <div class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm ring-1 ring-indigo-100">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3.75 14.5 9.5l5.75 2.5-5.75 2.5L12 20.25l-2.5-5.75-5.75-2.5 5.75-2.5L12 3.75Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="m19 3 .75 1.75L21.5 5.5l-1.75.75L19 8l-.75-1.75L16.5 5.5l1.75-.75L19 3Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <div>
                        <h2 id="report-preview-heading" class="text-sm font-semibold text-gray-900">Your AI-powered report will include</h2>
                        <p class="mt-1 text-sm text-gray-600">A concise, structured view to support your screening review.</p>
                        <ul class="mt-4 grid gap-2.5 text-sm text-gray-700 sm:grid-cols-2">
                            <li class="flex items-center gap-2">
                                <span class="flex size-5 items-center justify-center rounded-full bg-indigo-100 text-indigo-700" aria-hidden="true">
                                    <svg class="size-3" viewBox="0 0 16 16" fill="none"><path d="m3.5 8 3 3 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                Match score from 0 to 100
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="flex size-5 items-center justify-center rounded-full bg-indigo-100 text-indigo-700" aria-hidden="true">
                                    <svg class="size-3" viewBox="0 0 16 16" fill="none"><path d="m3.5 8 3 3 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                Top 5 matching skills
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="flex size-5 items-center justify-center rounded-full bg-indigo-100 text-indigo-700" aria-hidden="true">
                                    <svg class="size-3" viewBox="0 0 16 16" fill="none"><path d="m3.5 8 3 3 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                Top 3 skill gaps
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="flex size-5 items-center justify-center rounded-full bg-indigo-100 text-indigo-700" aria-hidden="true">
                                    <svg class="size-3" viewBox="0 0 16 16" fill="none"><path d="m3.5 8 3 3 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                                3 suggested interview questions
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <div class="flex flex-col gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="flex max-w-2xl items-start gap-2 text-xs leading-5 text-gray-500">
                    <svg class="mt-0.5 size-4 shrink-0 text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3.75 5 6.5v5.25c0 4.1 2.8 7.3 7 8.5 4.2-1.2 7-4.4 7-8.5V6.5l-7-2.75Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                        <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Resume and job description text is temporarily held in an encrypted processing queue, then discarded after analysis. Only the candidate name and completed report are retained.
                </p>
                <button
                    type="submit"
                    data-analysis-submit
                    class="inline-flex min-h-12 w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70 sm:w-auto"
                >
                    <svg data-submit-icon class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <svg data-submit-spinner class="hidden size-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"/>
                        <path class="opacity-90" fill="currentColor" d="M12 3a9 9 0 0 1 9 9h-3a6 6 0 0 0-6-6V3Z"/>
                    </svg>
                    <span data-submit-label>Analyze Resume</span>
                </button>
            </div>
            <p data-form-status class="sr-only" aria-live="polite"></p>
        </form>
    </div>
</x-app-layout>
